<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Reseller;
use App\Models\VoucherTransaction;
use App\Models\Employee;
use App\Models\Presence;
use App\Models\ClientAcquisition;
use App\Models\Deduction;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // cast password=hashed -> assign plain (jangan Hash::make double-hash)
        User::firstOrCreate(
            ['email'=>'admin@datanet.net'],
            ['name'=>'Admin', 'password'=>'password', 'role'=>'admin']
        );

        $this->call(AttendanceUserSeeder::class);

        $resellers = collect([
            ['nama'=>'Kios Cell Berkah','no_hp'=>'081234567801','alamat'=>'Jl. Raya Timur - Kios 01'],
            ['nama'=>'Warung Bu Siti','no_hp'=>'081234567802','alamat'=>'RT 05 RW 02'],
            ['nama'=>'Konter Andi Cell','no_hp'=>'081234567803','alamat'=>'Pertigaan Pasar'],
            ['nama'=>'Toko Sumber Rejeki','no_hp'=>'081234567804','alamat'=>'Jl. Desa Krajan'],
        ])->map(fn($d)=>Reseller::create($d));

        $types = config('voucher.types');
        $dates = [now()->subDays(12), now()->subDays(7), now()->subDays(3), now()];
        foreach($resellers as $i=>$r){
            $vt = ['3k','5k','10k'][$i % 3];
            $qty = [12,10,8,15][$i % 4];
            $t = $types[$vt];
            VoucherTransaction::create(['reseller_id'=>$r->id,'voucher_type'=>$vt,'qty'=>$qty,'harga_satuan'=>$t['reseller'],'harga_retail'=>$t['retail'],'tanggal'=>$dates[$i % 4],'nominal'=>$qty*$t['reseller'],'status'=>'belum_lunas','keterangan'=>$qty.' voucher '.$t['label']]);
            $t5 = $types['5k'];
            VoucherTransaction::create(['reseller_id'=>$r->id,'voucher_type'=>'5k','qty'=>20,'harga_satuan'=>$t5['reseller'],'harga_retail'=>$t5['retail'],'tanggal'=>now()->subDays(1),'nominal'=>20*$t5['reseller'],'status'=>'lunas','keterangan'=>'20 voucher '.$t5['label'].' lunas']);
        }
        $t5 = $types['5k'];
        VoucherTransaction::create(['reseller_id'=>$resellers[0]->id,'voucher_type'=>'5k','qty'=>50,'harga_satuan'=>$t5['reseller'],'harga_retail'=>$t5['retail'],'tanggal'=>now()->subDays(20),'nominal'=>50*$t5['reseller'],'status'=>'belum_lunas','keterangan'=>'50 voucher '.$t5['label'].' - belum dibayar']);

        $emps = collect([
            ['nama'=>'Budi Teknisi','jabatan'=>'teknisi','gaji_pokok'=>1800000,'bonus_per_hadir'=>15000,'no_hp'=>'081234560001'],
            ['nama'=>'Siti Marketing','jabatan'=>'marketing','gaji_pokok'=>1500000,'bonus_per_hadir'=>10000,'no_hp'=>'081234560002'],
            ['nama'=>'Andi Admin','jabatan'=>'admin','gaji_pokok'=>2000000,'bonus_per_hadir'=>10000,'no_hp'=>'081234560003'],
        ])->map(fn($d)=>Employee::create($d+['is_active'=>true]));

        foreach(range(1,10) as $d){
            $tgl = now()->startOfMonth()->addDays($d-1)->format('Y-m-d');
            if($d<=10) Presence::firstOrCreate(['employee_id'=>$emps[0]->id,'tanggal'=>$tgl],['status'=>'hadir']);
            if($d<=8) Presence::firstOrCreate(['employee_id'=>$emps[1]->id,'tanggal'=>$tgl],['status'=>'hadir']);
            if($d==9) Presence::firstOrCreate(['employee_id'=>$emps[1]->id,'tanggal'=>$tgl],['status'=>'izin']);
        }

        ClientAcquisition::create(['employee_id'=>$emps[0]->id,'nama_klien'=>'Pak Jono - RT 03','alamat_klien'=>'RT 03 RW 01','tanggal'=>now()->subDays(5),'nominal_insentif'=>75000,'keterangan'=>'Pasang 10 Mbps']);
        ClientAcquisition::create(['employee_id'=>$emps[0]->id,'nama_klien'=>'Bu Aminah - Krajan','alamat_klien'=>'Krajan Wetan','tanggal'=>now()->subDays(2),'nominal_insentif'=>75000,'keterangan'=>'Pasang 10 Mbps']);
        ClientAcquisition::create(['employee_id'=>$emps[1]->id,'nama_klien'=>'Warung Pak Dul','alamat_klien'=>'Pasar','tanggal'=>now()->subDays(3),'nominal_insentif'=>50000,'keterangan'=>'Marketing close']);

        Deduction::create(['employee_id'=>$emps[0]->id,'tanggal'=>now()->subDays(4),'nominal'=>200000,'keterangan'=>'Kasbon awal bulan','status'=>'belum_dipotong']);
        Deduction::create(['employee_id'=>$emps[1]->id,'tanggal'=>now()->subDays(6),'nominal'=>100000,'keterangan'=>'Kasbon','status'=>'belum_dipotong']);
    }
}