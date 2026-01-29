<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Alumno;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class ImportVentas extends Command
{
    protected $signature = 'import:ventas {file} {--form=}';
    protected $description = 'Importar ventas desde CSV (Google Forms)';

    public function handle()
    {
        $filePath = $this->argument('file');
        $formOrigen = $this->option('form') ?? 'desconocido';

        if (!file_exists($filePath)) {
            $this->error("Archivo no encontrado: $filePath");
            return 1;
        }

        $handle = fopen($filePath, 'r');
        $headers = fgetcsv($handle);

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($headers, $row);

                // Ajusta estos nombres a tus columnas reales
                $dni = trim($data['DNI'] ?? '');

                if ($dni === '') {
                    continue;
                }

                $alumno = Alumno::firstOrCreate(
                    ['dni' => $dni],
                    [
                        'nombres'   => $data['Nombres'] ?? null,
                        'apellidos' => $data['Apellidos'] ?? null,
                        'email'     => $data['Correo'] ?? null,
                        'telefono'  => $data['Telefono'] ?? null,
                    ]
                );

                Venta::create([
                    'alumno_id'   => $alumno->id,
                    'dni'         => $dni,
                    'curso'       => $data['Curso'] ?? 'No especificado',
                    'monto'       => $data['Monto'] ?? null,
                    'medio_pago'  => $data['Medio de pago'] ?? null,
                    'fecha_venta' => isset($data['Fecha'])
                        ? date('Y-m-d', strtotime($data['Fecha']))
                        : null,
                    'form_origen' => $formOrigen,
                    'raw_data'    => json_encode($data),
                ]);
            }

            DB::commit();
            $this->info('Importación completada correctamente');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
        }

        fclose($handle);
        return 0;
    }
}
