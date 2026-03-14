<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['name' => 'Apex Technology Solutions', 'email' => 'procurement@apextech.com', 'phone' => '+1-212-555-0101', 'address' => '350 Fifth Avenue, New York, NY 10118'],
            ['name' => 'Bright Future Academy', 'email' => 'orders@brightfutureacademy.edu', 'phone' => '+1-310-555-0142', 'address' => '1200 Wilshire Blvd, Los Angeles, CA 90017'],
            ['name' => 'CloudNine Startups Ltd', 'email' => 'finance@cloudninestartups.io', 'phone' => '+1-415-555-0198', 'address' => '535 Mission St, San Francisco, CA 94105'],
            ['name' => 'Delta Office Supplies Co.', 'email' => 'purchasing@deltaoffice.com', 'phone' => '+1-312-555-0173', 'address' => '233 S Wacker Dr, Chicago, IL 60606'],
            ['name' => 'Evergreen Medical Centre', 'email' => 'admin@evergreenmedical.org', 'phone' => '+1-713-555-0122', 'address' => '6565 Fannin St, Houston, TX 77030'],
            ['name' => 'FrontRow Digital Agency', 'email' => 'billing@frontrowdigital.co', 'phone' => '+1-602-555-0161', 'address' => '2394 E Camelback Rd, Phoenix, AZ 85016'],
            ['name' => 'GreenLeaf Architecture', 'email' => 'accounts@greenleafarch.com', 'phone' => '+1-215-555-0134', 'address' => '1500 Market St, Philadelphia, PA 19102'],
            ['name' => 'Horizon Freight & Logistics', 'email' => 'supplies@horizonfreight.net', 'phone' => '+1-210-555-0189', 'address' => '100 W Houston St, San Antonio, TX 78205'],
            ['name' => 'InnovateTech Pvt Ltd', 'email' => 'it@innovatetech.in', 'phone' => '+91-98200-55012', 'address' => '14 Rajiv Gandhi IT Park, Pune, MH 411014'],
            ['name' => 'Jade River Consulting', 'email' => 'ops@jaderiverconsulting.com', 'phone' => '+1-619-555-0176', 'address' => '600 B St, San Diego, CA 92101'],
            ['name' => 'Keystroke Publishing House', 'email' => 'purchases@keystrokebooks.com', 'phone' => '+1-503-555-0145', 'address' => '921 SW Washington St, Portland, OR 97205'],
            ['name' => 'LightSpeed Courier Services', 'email' => 'fleet@lightspeedcourier.com', 'phone' => '+1-702-555-0118', 'address' => '3800 Howard Hughes Pkwy, Las Vegas, NV 89169'],
            ['name' => 'Maple Grove Hotel Group', 'email' => 'procurement@maplegrovehospitality.com', 'phone' => '+1-206-555-0167', 'address' => '400 Broad St, Seattle, WA 98109'],
            ['name' => 'Nexus Law Associates', 'email' => 'admin@nexuslaw.com', 'phone' => '+1-303-555-0193', 'address' => '1700 Lincoln St, Denver, CO 80203'],
            ['name' => 'OmniCloud Systems', 'email' => 'finance@omnicloud.systems', 'phone' => '+1-512-555-0128', 'address' => '201 W 5th St, Austin, TX 78701'],
            ['name' => 'PinnacleCare Pharmacy', 'email' => 'orders@pinnaclecarepharmacy.com', 'phone' => '+1-904-555-0149', 'address' => '1 Independent Dr, Jacksonville, FL 32202'],
            ['name' => 'QuestMedia Productions', 'email' => 'studio@questmediaproductions.tv', 'phone' => '+1-615-555-0137', 'address' => '333 Commerce St, Nashville, TN 37201'],
            ['name' => 'Redwood Realty Group', 'email' => 'it@redwoodrealty.com', 'phone' => '+1-971-555-0182', 'address' => '811 SW 6th Avenue, Portland, OR 97204'],
            ['name' => 'Sunrise School District', 'email' => 'tech@sunrisesd.k12.us', 'phone' => '+1-702-555-0155', 'address' => '2832 E Flamingo Rd, Las Vegas, NV 89121'],
            ['name' => 'Titan Construction Group', 'email' => 'site@titanconstruction.build', 'phone' => '+1-404-555-0111', 'address' => '191 Peachtree St NE, Atlanta, GA 30303'],
            ['name' => 'Uniflex Manufacturing Ltd', 'email' => 'supply@uniflexmfg.com', 'phone' => '+1-216-555-0196', 'address' => '200 Public Square, Cleveland, OH 44114'],
            ['name' => 'Velocity Sports & Fitness', 'email' => 'gear@velocitysports.com', 'phone' => '+1-813-555-0163', 'address' => '400 N Ashley Dr, Tampa, FL 33602'],
            ['name' => 'WaveForm Audio Studio', 'email' => 'gear@waveformaudio.studio', 'phone' => '+1-505-555-0177', 'address' => '400 Marquette Ave NW, Albuquerque, NM 87102'],
            ['name' => 'Xanadu Events & Catering', 'email' => 'events@xanaduvenues.com', 'phone' => '+1-704-555-0141', 'address' => '128 S Tryon St, Charlotte, NC 28202'],
            ['name' => 'Zenith Healthcare Supplies', 'email' => 'orders@zenithhealthsupplies.com', 'phone' => '+1-480-555-0158', 'address' => '2 N Central Ave, Phoenix, AZ 85004'],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate(['email' => $customer['email']], $customer);
        }
    }
}
