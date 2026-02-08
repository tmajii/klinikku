<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ImportPasienSeeder extends Seeder
{
    public function run()
    {
        // Fetch data from JSONPlaceholder
        $url = 'https://jsonplaceholder.typicode.com/users';
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            echo "cURL Error: " . curl_error($ch) . "\n";
            curl_close($ch);
            return;
        }
        
        curl_close($ch);
        
        if ($httpCode !== 200) {
            echo "HTTP Error: " . $httpCode . "\n";
            return;
        }
        
        $users = json_decode($response, true);
        
        if (!$users || !is_array($users)) {
            echo "Failed to decode JSON data\n";
            return;
        }
        
        echo "Fetched " . count($users) . " users from JSONPlaceholder\n";
        
        // Prepare data for insertion
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
        
        // Insert data
        $builder = $this->db->table('pasien');
        
        // Clear existing data (optional)
        // $builder->truncate();
        
        // Insert batch
        if ($builder->insertBatch($data)) {
            echo "Successfully imported " . count($data) . " patients\n";
        } else {
            echo "Failed to import data\n";
        }
    }
}
