<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ImportPasien extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'import:pasien';
    protected $description = 'Import data pasien dari JSONPlaceholder';
    protected $usage       = 'import:pasien [options]';
    protected $arguments   = [];
    protected $options     = [
        '--truncate' => 'Hapus semua data pasien sebelum import'
    ];

    public function run(array $params)
    {
        CLI::write('Mengambil data dari JSONPlaceholder...', 'yellow');
        
        // Fetch data from JSONPlaceholder
        $url = 'https://jsonplaceholder.typicode.com/users';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            CLI::error('cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return;
        }
        
        curl_close($ch);
        
        if ($httpCode !== 200) {
            CLI::error('HTTP Error: ' . $httpCode);
            return;
        }
        
        $users = json_decode($response, true);
        
        if (!$users || !is_array($users)) {
            CLI::error('Gagal decode JSON data');
            return;
        }
        
        CLI::write('Berhasil mengambil ' . count($users) . ' data user', 'green');
        
        // Prepare data
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'norm' => 'RM' . str_pad($user['id'], 6, '0', STR_PAD_LEFT),
                'nama' => $user['name'],
                'alamat' => $user['address']['street'] . ', ' . $user['address']['suite'] . ', ' . 
                           $user['address']['city'] . ' - ' . $user['address']['zipcode'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        
        $db = \Config\Database::connect();
        $builder = $db->table('pasien');
        
        // Truncate if option provided
        if (CLI::getOption('truncate')) {
            CLI::write('Menghapus data pasien yang ada...', 'yellow');
            $builder->truncate();
        }
        
        // Insert data
        CLI::write('Mengimport data ke database...', 'yellow');
        
        if ($builder->insertBatch($data)) {
            CLI::write('Berhasil import ' . count($data) . ' data pasien!', 'green');
            CLI::newLine();
            
            // Show sample data
            CLI::write('Sample data:', 'cyan');
            foreach (array_slice($data, 0, 3) as $pasien) {
                CLI::write('  - ' . $pasien['norm'] . ' | ' . $pasien['nama'], 'white');
            }
        } else {
            CLI::error('Gagal import data');
        }
    }
}
