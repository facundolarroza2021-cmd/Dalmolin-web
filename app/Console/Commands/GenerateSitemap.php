<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    /**
     * El nombre (firma) que usaremos en la terminal.
     */
    protected $signature = 'sitemap:generate';

    /**
     * Descripción del comando.
     */
    protected $description = 'Genera el archivo sitemap.xml para Google automáticamente';

    /**
     * Ejecución lógica del comando.
     */
    public function handle()
    {
        // Verifica que la URL en .env sea correcta antes de empezar
        $url = config('app.url');
        $path = public_path('sitemap.xml');

        $this->info("Iniciando escaneo de: {$url}");

        try {
            // Generar el sitemap
            SitemapGenerator::create($url)
                ->writeToFile($path);

            $this->info("¡Éxito! Sitemap generado en: {$path}");
            
        } catch (\Exception $e) {
            $this->error("Error al generar sitemap: " . $e->getMessage());
            $this->warn("Consejo: Revisa que tu servidor esté corriendo (npm run dev / sail up) y que la APP_URL en el .env sea accesible.");
        }
    }
}