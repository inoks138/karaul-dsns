<?php

namespace App\Services\Emergency;

use App\Models\Emergency\Emergency;
use App\Models\Emergency\EmergencyComment;
use App\Models\Emergency\EmergencyLiquidation;
use App\Models\Emergency\EmergencyLiquidationRequest;
use App\Models\Emergency\EmergencyType;
use Illuminate\Database\Eloquent\Collection;

class EmergencyService
{
    public function getTypes(): Collection
    {
        return EmergencyType::query()
            ->orderBy('name')
            ->get();
    }

    public function getEmergency(Emergency $emergency): Emergency
    {
        $this->loadEmergencyData($emergency);

        return $emergency;
    }

    public function getActiveEmergencies(): Collection
    {
        return Emergency::query()
            ->with([
                'reporterWorkplace',
                'type',
                'liquidationRequest' => function ($query) {
                    $query->where('firehouse_id', auth()->user()->employee->workplace_id);
                },
            ])
            ->where('closed_at', null)
            ->orderBy('reported_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->workplace_name =
                    Emergency::getReporterWorkplaceNameByType($item->reporter_workplace_type) . '-' . $item->reporterWorkplace->number;

                return $item;
            });
    }

    public function acceptLiquidation(Emergency $emergency): void
    {
        $firehouseId = auth()->user()->employee->workplace_id;

        EmergencyLiquidationRequest::query()
            ->where('emergency_id', $emergency->id)
            ->where('firehouse_id', $firehouseId)
            ->update([
                'is_accepted' => true,
            ]);
    }

    public function declineLiquidation(Emergency $emergency, array $data): void
    {
        $firehouseId = auth()->user()->employee->workplace_id;

        EmergencyLiquidationRequest::query()
            ->where('emergency_id', $emergency->id)
            ->where('firehouse_id', $firehouseId)
            ->update([
                'is_accepted' => false,
                'decline_comment' => $data['comment'],
            ]);
    }

    public function closeLiquidation(Emergency $emergency): void
    {
        $emergency->update([
            'closed_at' => now(),
        ]);
    }

    public function syncLiquidations(Emergency $emergency, array $data): Emergency
    {
        foreach ($data['liquidations'] as $liquidationData) {
            $payload = [
                'emergency_id' => $emergency->id,
                'unit_id' => $liquidationData['unit_id'],
                'vehicle_id' => $liquidationData['vehicle_id'],
                'departured_at' => $liquidationData['departured_at'],
                'arrived_at' => $liquidationData['arrived_at'],
                'first_barrel_delivered_at' => $liquidationData['first_barrel_delivered_at'],
                'localized_at' => $liquidationData['localized_at'],
                'liquidated_at' => $liquidationData['liquidated_at'],
                'returned_at' => $liquidationData['returned_at'],
            ];

            if ($liquidationData['id']) {
                EmergencyLiquidation::where('id', $liquidationData['id'])->update($payload);
            } else {
                EmergencyLiquidation::create($payload);
            }
        }

        $this->loadEmergencyData($emergency);

        return $emergency;
    }

    public function getComments(Emergency $emergency): Collection
    {
        return EmergencyComment::query()
            ->with(['employee'])
            ->where('emergency_id', $emergency->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function storeComment(Emergency $emergency, array $data): EmergencyComment
    {
        $comment = EmergencyComment::create([
            'emergency_id' => $emergency->id,
            'comment' => $data['comment'],
            'employee_id' => auth()->user()->employee->id,
        ]);

        $comment->load('employee');

        return $comment;
    }

    private function loadEmergencyData(Emergency $emergency): void
    {
        $emergency->load([
            'liquidations',
            'liquidations.unit',
            'liquidations.unit.commander',
            'liquidations.vehicle',
            'liquidations.vehicle.model',
            'reporterWorkplace',
            'type',
            'liquidationRequest' => function ($query) {
                $query->where('firehouse_id', auth()->user()->employee->workplace_id);
            },
        ]);

        $emergency->workplace_name =
            Emergency::getReporterWorkplaceNameByType($emergency->reporter_workplace_type) . '-' . $emergency->reporterWorkplace->number;
    }
}
