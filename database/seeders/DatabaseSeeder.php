<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Disaster;
use App\Models\Tip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ─────────────────────────────────────────────────────────────

        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'location' => 'New Delhi, India',
        ]);

        $user = User::create([
            'name'     => 'Priya Sharma',
            'email'    => 'user@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'location' => 'Mumbai, Maharashtra',
        ]);

        User::create([
            'name'     => 'Rajan Mehta',
            'email'    => 'rajan@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'location' => 'Ahmedabad, Gujarat',
        ]);

        // ── Disasters ─────────────────────────────────────────────────────────

        $disasters = [
            [
                'name'        => 'Kerala Flood Preparedness Guide',
                'type'        => 'flood',
                'severity'    => 'critical',
                'region'      => 'Kerala, India',
                'description' => 'Floods are one of the most common and devastating natural disasters in Kerala, occurring almost every monsoon season. The 2018 Kerala floods displaced over a million people. Understanding flood risks and preparing in advance can save lives.',
                'what_to_do'  => "• Move to higher ground immediately when warned.\n• Store at least 72 hours of drinking water (4L per person per day).\n• Waterproof your important documents — keep them in zip-lock bags.\n• Know your nearest evacuation shelter and the safest route to it.\n• Keep a battery-powered radio for updates when power fails.\n• Turn off electricity at the main switch before leaving.\n• Help neighbours, especially elderly and disabled persons.",
                'what_not_to_do' => "• Do not walk or drive through floodwater — even 6 inches can knock you down.\n• Do not touch electrical equipment if wet or standing in water.\n• Do not return home until authorities declare it safe.\n• Do not drink tap water after a flood without boiling it first.\n• Do not ignore evacuation orders — your belongings can be replaced.",
                'views'       => 842,
            ],
            [
                'name'        => 'Earthquake Safety — Golden Rules',
                'type'        => 'earthquake',
                'severity'    => 'high',
                'region'      => 'North India (Seismic Zone IV–V)',
                'description' => 'India sits on highly active tectonic plates making it earthquake-prone, especially the Himalayan belt. Earthquakes strike without warning — your preparedness before the shaking begins is everything. Seconds matter.',
                'what_to_do'  => "• DROP to the ground, take COVER under a sturdy table, and HOLD ON.\n• Stay away from windows, exterior walls, and heavy furniture.\n• If outdoors, move away from buildings and power lines.\n• After shaking stops, check for injuries and hazards before moving.\n• Expect and prepare for aftershocks.\n• Use stairs — never elevators — to exit buildings.\n• Keep shoes near your bed in case of broken glass.",
                'what_not_to_do' => "• Do not run outside during shaking — most injuries occur from falling debris while fleeing.\n• Do not stand in doorways — this is an outdated myth.\n• Do not use elevators after an earthquake.\n• Do not light candles or matches until you are certain there are no gas leaks.\n• Do not spread unverified news on social media — it causes panic.",
                'views'       => 617,
            ],
            [
                'name'        => 'Cyclone Preparedness for Coastal Communities',
                'type'        => 'cyclone',
                'severity'    => 'critical',
                'region'      => 'Odisha / Andhra Pradesh Coast',
                'description' => 'India\'s eastern coastline faces multiple cyclones each year from the Bay of Bengal. The Odisha government\'s zero-casualty model has become a global example. Preparation 48–72 hours before landfall is the key window.',
                'what_to_do'  => "• Stock at least 7 days of food, water, and essential medicines.\n• Board up windows and secure loose outdoor objects.\n• Charge all devices and keep portable power banks ready.\n• Identify and register at your nearest cyclone shelter.\n• Fill bathtubs and large containers with water before the storm hits.\n• Keep a battery radio on hand — power will likely fail.\n• Follow official advisories from IMD (India Meteorological Department).",
                'what_not_to_do' => "• Do not ignore evacuation orders even if you've survived past cyclones.\n• Do not go outside during the eye of the storm — winds return.\n• Do not shelter under trees or near power lines.\n• Do not attempt to drive unless absolutely necessary.\n• Do not spread rumours about cyclone paths.",
                'views'       => 534,
            ],
            [
                'name'        => 'Urban Fire Safety & Prevention',
                'type'        => 'fire',
                'severity'    => 'high',
                'region'      => 'All India — Urban Areas',
                'description' => 'Fires in urban Indian homes are frequently caused by short circuits, LPG cylinder leaks, and overloaded electrical sockets. Most fire deaths are preventable with basic preparation. Every household needs a plan.',
                'what_to_do'  => "• Install smoke detectors on every floor and test them monthly.\n• Plan and practice two escape routes from every room.\n• Keep a fire extinguisher in the kitchen — learn how to use it before emergencies.\n• In case of fire: GET OUT, STAY OUT, CALL 101.\n• If trapped, signal from a window — do not hide.\n• Feel doors before opening — if hot, find another exit.\n• Stop, Drop, and Roll if your clothes catch fire.",
                'what_not_to_do' => "• Do not go back inside a burning building for any reason.\n• Do not use water on electrical or grease fires.\n• Do not open doors if smoke is coming from underneath.\n• Do not leave cooking unattended — most kitchen fires start this way.\n• Do not overload power sockets with adaptors.",
                'views'       => 389,
            ],
            [
                'name'        => 'Landslide Risk in Hill Districts',
                'type'        => 'landslide',
                'severity'    => 'medium',
                'region'      => 'Western Ghats / Uttarakhand / Himachal Pradesh',
                'description' => 'Landslides in India kill hundreds every year, especially during heavy monsoon rainfall. Hilly states like Kerala, Uttarakhand, and Himachal Pradesh are particularly vulnerable. Most landslide deaths are preventable by early warning and timely evacuation.',
                'what_to_do'  => "• Monitor local weather forecasts and IMD landslide alerts during monsoon.\n• Know the warning signs: unusual sounds (cracking, rumbling), tilting trees, sudden spring water.\n• Evacuate immediately when warned — do not wait to see if it's serious.\n• Move at right angles to the slide, not up or downhill.\n• Contact local disaster management authority if you notice slope instability.\n• Keep emergency supplies ready for rapid evacuation.",
                'what_not_to_do' => "• Do not build houses on steep slopes or at the base of hills prone to slides.\n• Do not ignore small slips or cracks in the ground — they warn of larger slides.\n• Do not block natural drainage channels near slopes.\n• Do not stay near rivers and streams during heavy rainfall in hilly areas.\n• Do not attempt rescue without professional help.",
                'views'       => 276,
            ],
            [
                'name'        => 'Pandemic Household Preparedness',
                'type'        => 'pandemic',
                'severity'    => 'high',
                'region'      => 'All India',
                'description' => 'The COVID-19 pandemic showed that pandemics can disrupt daily life for months. Being prepared at the household level — with medicines, food, PPE, and a care plan — dramatically reduces risk and anxiety during a health emergency.',
                'what_to_do'  => "• Maintain a 30-day supply of essential prescription medicines.\n• Stock N95 masks, disposable gloves, and hand sanitizer.\n• Identify an isolation room in your home for sick family members.\n• Store at least two weeks of non-perishable food.\n• Keep a thermometer and pulse oximeter accessible.\n• Stay updated only through official government sources (MoHFW).\n• Get vaccinated and keep vaccinations up to date.",
                'what_not_to_do' => "• Do not share medicines without medical advice.\n• Do not panic-buy — it creates shortages for others.\n• Do not spread unverified health information on social media.\n• Do not ignore symptoms — seek medical advice early.\n• Do not stigmatise infected individuals or families.",
                'views'       => 198,
            ],
        ];

        foreach ($disasters as $data) {
            Disaster::create(array_merge($data, [
                'slug'       => Str::slug($data['name']) . '-' . rand(1000, 9999),
                'is_active'  => true,
                'created_by' => $admin->id,
            ]));
        }

        // ── Emergency Contacts ────────────────────────────────────────────────

        $contacts = [
            ['name' => 'AIIMS New Delhi',           'type' => 'hospital',  'phone' => '011-26588500', 'city' => 'New Delhi',  'state' => 'Delhi'],
            ['name' => 'Lilavati Hospital Mumbai',   'type' => 'hospital',  'phone' => '022-26751000', 'city' => 'Mumbai',     'state' => 'Maharashtra'],
            ['name' => 'Delhi Police Control Room',  'type' => 'police',    'phone' => '100',           'city' => 'New Delhi',  'state' => 'Delhi'],
            ['name' => 'Mumbai Police Control',      'type' => 'police',    'phone' => '100',           'city' => 'Mumbai',     'state' => 'Maharashtra'],
            ['name' => 'Delhi Fire Service',         'type' => 'fire',      'phone' => '101',           'city' => 'New Delhi',  'state' => 'Delhi'],
            ['name' => 'Mumbai Fire Brigade',        'type' => 'fire',      'phone' => '101',           'city' => 'Mumbai',     'state' => 'Maharashtra'],
            ['name' => 'National Disaster Helpline', 'type' => 'helpline',  'phone' => '1078',          'city' => 'New Delhi',  'state' => 'Delhi'],
            ['name' => 'NDRF Headquarters',          'type' => 'ngo',       'phone' => '011-24363260',  'city' => 'New Delhi',  'state' => 'Delhi'],
            ['name' => 'Red Cross India',            'type' => 'ngo',       'phone' => '011-23716441',  'city' => 'New Delhi',  'state' => 'Delhi'],
            ['name' => 'Ambulance (National)',       'type' => 'helpline',  'phone' => '108',           'city' => 'All India',  'state' => 'National'],
            ['name' => 'Hyderabad Disaster Response','type' => 'ngo',       'phone' => '040-23453456',  'city' => 'Hyderabad',  'state' => 'Telangana'],
            ['name' => 'Chennai Flood Helpline',     'type' => 'helpline',  'phone' => '1800-425-1188', 'city' => 'Chennai',    'state' => 'Tamil Nadu'],
            ['name' => 'Apollo Hospital Chennai',    'type' => 'hospital',  'phone' => '044-28293333',  'city' => 'Chennai',    'state' => 'Tamil Nadu'],
            ['name' => 'Kolkata Fire Brigade',       'type' => 'fire',      'phone' => '101',           'city' => 'Kolkata',    'state' => 'West Bengal'],
            ['name' => 'Bengaluru BBMP Helpline',    'type' => 'helpline',  'phone' => '080-22221188',  'city' => 'Bengaluru',  'state' => 'Karnataka'],
        ];

        foreach ($contacts as $c) {
            Contact::create(array_merge($c, ['is_available' => true]));
        }

        // ── Community Tips ────────────────────────────────────────────────────

        $tips = [
            [
                'title'         => 'Keep a "go bag" packed and by the door before monsoon starts',
                'body'          => 'During the 2018 Kerala floods we had less than 20 minutes to evacuate. What saved us was a bag we had packed at the start of June with copies of all documents, cash, medicines, torch, charger, and 2 days of dry food. When the water rose, we grabbed it and left. Everyone in flood-prone areas should do this every year before June.',
                'disaster_type' => 'flood',
                'region'        => 'Kerala',
                'is_approved'   => true,
            ],
            [
                'title'         => 'Practice the earthquake drill with children — make it a game',
                'body'          => 'After the 2015 Nepal earthquake we moved to Delhi and I was terrified my kids wouldn\'t know what to do. We started doing "earthquake drills" at home — drop, cover, hold on — once a month as a kind of game with a prize. Two years later during a minor tremor, my son immediately went under his desk without me saying anything. It works.',
                'disaster_type' => 'earthquake',
                'region'        => 'Delhi',
                'is_approved'   => true,
            ],
            [
                'title'         => 'Neighbours are your most important emergency contact',
                'body'          => 'When Cyclone Fani hit Odisha in 2019, mobile networks went down within minutes. The people who survived well were those who knew their neighbours and had agreed in advance to check on each other. We had a WhatsApp group for our street with offline meeting points. Simple things like that matter enormously when systems fail.',
                'disaster_type' => 'cyclone',
                'region'        => 'Odisha',
                'is_approved'   => true,
            ],
            [
                'title'         => 'Test your smoke detector — most people never do',
                'body'          => 'I\'m a fire safety trainer and the single biggest issue I see is that people buy smoke detectors and never test them. Press the test button monthly. Replace the battery every year. A detector with a dead battery is worse than useless — it gives false confidence. Also: clean them with a vacuum cleaner once a year, dust clogs the sensors.',
                'disaster_type' => 'fire',
                'region'        => 'Mumbai',
                'is_approved'   => true,
            ],
            [
                'title'         => 'Store water in multiple small containers, not one big tank',
                'body'          => 'During COVID lockdown we had 3 months of disrupted water supply. We learned the hard way that one large tank means one point of failure. Now we store water in ten 20-litre containers spread across two rooms. If one gets contaminated or knocked over, the others are fine. Also rotate stock monthly — stagnant water becomes unsafe.',
                'disaster_type' => 'pandemic',
                'region'        => 'Pune',
                'is_approved'   => true,
            ],
        ];

        foreach ($tips as $t) {
            $user->tips()->create($t);
        }
    }
}
