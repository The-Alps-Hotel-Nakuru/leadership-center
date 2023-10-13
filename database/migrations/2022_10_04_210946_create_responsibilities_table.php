<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('designation_id')->constrained();
            $table->mediumText('responsibility');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });


        $designationResponsibilities = [
            [
                'designation' => 'Laundry Attendant',
                'responsibilities' => [
                    'Collect dirty laundry from guest rooms.',
                    'Sort and wash laundry items following proper procedures.',
                    'Fold and organize clean laundry.',
                    'Report any damaged items to the supervisor.',
                    'Maintain cleanliness in the laundry area.',
                    'Assist guests with laundry-related queries.',
                    'Operate laundry equipment safely.',
                    'Adhere to departmental policies and procedures.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Room Attendant',
                'responsibilities' => [
                    'Clean and tidy guest rooms.',
                    'Change bed linens and towels.',
                    'Restock room amenities.',
                    'Report any maintenance issues in guest rooms.',
                    'Provide exceptional guest service.',
                    'Follow cleaning and safety protocols.',
                    'Coordinate with housekeeping supervisor.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Public Area Attendant',
                'responsibilities' => [
                    'Clean and maintain public areas of the hotel.',
                    'Sweep, mop, and vacuum floors.',
                    'Empty trash bins and replace liners.',
                    'Restock cleaning supplies.',
                    'Report any maintenance issues.',
                    'Provide assistance to guests.',
                    'Adhere to cleanliness standards.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Housekeeping Supervisor',
                'responsibilities' => [
                    'Supervise and train housekeeping staff.',
                    'Ensure guest rooms are cleaned to standards.',
                    'Schedule housekeeping shifts.',
                    'Order and maintain cleaning supplies.',
                    'Handle guest complaints and requests.',
                    'Monitor staff performance.',
                    'Ensure safety and cleanliness standards are met.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Senior Accountant',
                'responsibilities' => [
                    'Prepare financial reports and statements.',
                    'Review financial transactions for accuracy and compliance.',
                    'Assist in budget planning and forecasting.',
                    'Analyze financial data to identify trends and opportunities.',
                    'Ensure timely and accurate financial record-keeping.',
                    'Collaborate with auditors and tax authorities.',
                    'Provide financial guidance to junior accountants.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Junior Accountant',
                'responsibilities' => [
                    'Assist in preparing financial reports and statements.',
                    'Record financial transactions accurately.',
                    'Assist in budget tracking and analysis.',
                    'Maintain financial records and documentation.',
                    'Support senior accountants in various tasks.',
                    'Contribute to financial data analysis.',
                    'Participate in financial audits and compliance checks.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Chief Technology Officer',
                'responsibilities' => [
                    'Develop and implement technology strategies.',
                    'Oversee IT infrastructure and systems.',
                    'Lead technology innovation and R&D efforts.',
                    'Manage IT teams and projects.',
                    'Ensure data security and privacy.',
                    'Collaborate with other departments on technology needs.',
                    'Evaluate and recommend IT solutions.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Networking and Communications Attendant',
                'responsibilities' => [
                    'Install and maintain network equipment.',
                    'Troubleshoot network and communication issues.',
                    'Assist in setting up and configuring communication systems.',
                    'Monitor network performance and security.',
                    'Provide technical support to end-users.',
                    'Collaborate with IT teams on network projects.',
                    'Document network configurations and changes.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Hardware Engineer',
                'responsibilities' => [
                    'Design and develop hardware components and systems.',
                    'Test and troubleshoot hardware prototypes.',
                    'Collaborate with software engineers on system integration.',
                    'Evaluate and select hardware components.',
                    'Ensure hardware compliance with industry standards.',
                    'Create technical documentation and schematics.',
                    'Participate in hardware design reviews.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Systems Analyst',
                'responsibilities' => [
                    'Analyze business processes and requirements.',
                    'Design and implement information systems solutions.',
                    'Conduct system testing and quality assurance.',
                    'Provide technical support and training to end-users.',
                    'Evaluate and recommend software solutions.',
                    'Collaborate with cross-functional teams on projects.',
                    'Document system specifications and user manuals.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Procurement Officer',
                'responsibilities' => [
                    'Coordinate and manage procurement activities.',
                    'Identify suppliers and negotiate contracts.',
                    'Ensure cost-effective procurement of goods and services.',
                    'Maintain procurement records and documentation.',
                    'Collaborate with other departments on procurement needs.',
                    'Monitor supplier performance and compliance.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Dry Goods Storekeeper',
                'responsibilities' => [
                    'Receive and inspect incoming goods and materials.',
                    'Maintain inventory of dry goods and supplies.',
                    'Label and store items in an organized manner.',
                    'Prepare and pack goods for distribution.',
                    'Monitor stock levels and reorder as needed.',
                    'Maintain cleanliness and order in the storage area.',
                    'Assist with inventory audits.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Equipments Storekeeper',
                'responsibilities' => [
                    'Receive, inspect, and store equipment and tools.',
                    'Maintain an accurate inventory of equipment.',
                    'Perform regular equipment checks and maintenance.',
                    'Prepare equipment for distribution and use.',
                    'Track equipment usage and repairs.',
                    'Ensure the security and safety of stored equipment.',
                    'Assist with equipment maintenance scheduling.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Storage Clerk',
                'responsibilities' => [
                    'Organize and manage storage areas and facilities.',
                    'Receive, store, and retrieve items as needed.',
                    'Maintain accurate records of stored items.',
                    'Assist with inventory counts and audits.',
                    'Ensure the cleanliness and order of storage spaces.',
                    'Label and tag items for easy identification.',
                    'Assist colleagues with accessing stored items.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Receptionist',
                'responsibilities' => [
                    'Greet and assist guests upon arrival.',
                    'Handle check-in and check-out procedures.',
                    'Answer phone calls and respond to inquiries.',
                    'Provide information about hotel services and amenities.',
                    'Manage reservations and room assignments.',
                    'Ensure a positive and welcoming guest experience.',
                    'Maintain the reception area in an organized manner.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Front Office Supervisor',
                'responsibilities' => [
                    'Supervise front office staff and operations.',
                    'Manage guest check-in and check-out processes.',
                    'Handle guest requests and concerns.',
                    'Coordinate with other hotel departments.',
                    'Monitor and maintain room availability.',
                    'Assist in training and mentoring front office personnel.',
                    'Ensure compliance with hotel policies and procedures.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Driver',
                'responsibilities' => [
                    'Operate a vehicle to transport guests or materials.',
                    'Ensure safe and efficient driving practices.',
                    'Adhere to traffic laws and regulations.',
                    'Maintain the cleanliness and safety of the vehicle.',
                    'Assist passengers with loading and unloading.',
                    'Keep records of trips and vehicle maintenance.',
                    'Report any vehicle issues or incidents.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Concierge',
                'responsibilities' => [
                    'Provide information and assistance to guests.',
                    'Make reservations for dining and entertainment.',
                    'Arrange transportation and tours for guests.',
                    'Handle guest requests and special arrangements.',
                    'Maintain knowledge of local attractions and services.',
                    'Ensure a high level of guest satisfaction.',
                    'Coordinate with other hotel departments.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Cart Waiter/Waitress',
                'responsibilities' => [
                    'Take orders and serve food and beverages to guests.',
                    'Set up dining areas and prepare tables for service.',
                    'Explain menu items and specials to customers.',
                    'Ensure guest satisfaction and resolve issues.',
                    'Assist with clearing tables and resetting for the next guest.',
                    'Handle cash and payments accurately.',
                    'Adhere to food safety and hygiene standards.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Host/Hostess',
                'responsibilities' => [
                    'Greet and welcome guests at the restaurant entrance.',
                    'Manage the seating and reservation process.',
                    'Escort guests to their tables and provide menus.',
                    'Coordinate with servers and kitchen staff.',
                    'Handle special requests and guest concerns.',
                    'Maintain a neat and organized host/hostess station.',
                    'Ensure a smooth and efficient flow of guests.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Banquet Waiter/Waitress',
                'responsibilities' => [
                    'Set up banquet halls and dining areas for events.',
                    'Serve food and beverages to banquet guests.',
                    'Assist with event preparations and decorations.',
                    'Coordinate with event organizers and kitchen staff.',
                    'Ensure guest satisfaction during banquet events.',
                    'Clear tables and clean up after events.',
                    'Adhere to banquet service standards.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Barista',
                'responsibilities' => [
                    'Prepare and serve coffee and specialty beverages.',
                    'Take customer orders and handle payments.',
                    'Maintain cleanliness and organization of the coffee station.',
                    'Explain menu options and make recommendations.',
                    'Ensure quality and consistency in coffee preparation.',
                    'Provide excellent customer service.',
                    'Stock and replenish coffee supplies.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Food, Beverage and Service Supervisor',
                'responsibilities' => [
                    'Supervise food and beverage service staff.',
                    'Ensure high-quality guest service in restaurants and bars.',
                    'Manage dining reservations and seating arrangements.',
                    'Handle guest feedback and resolve issues.',
                    'Assist in training and development of service personnel.',
                    'Coordinate with kitchen and bar staff for smooth operations.',
                    'Maintain compliance with food safety standards.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Head Chef',
                'responsibilities' => [
                    'Oversee kitchen operations and staff.',
                    'Plan and create menus and recipes.',
                    'Manage food preparation and presentation.',
                    'Maintain food quality and safety standards.',
                    'Order and manage kitchen supplies and ingredients.',
                    'Train and supervise kitchen staff.',
                    'Ensure compliance with health and safety regulations.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Sous Chef',
                'responsibilities' => [
                    'Assist the head chef in kitchen management.',
                    'Supervise food preparation and cooking.',
                    'Coordinate kitchen staff and workflow.',
                    'Ensure food quality and presentation.',
                    'Manage kitchen inventory and supplies.',
                    'Assist in menu planning and development.',
                    'Maintain kitchen hygiene and safety.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Station Chef',
                'responsibilities' => [
                    'Prepare and cook specific station dishes.',
                    'Ensure consistency and quality in station items.',
                    'Manage station inventory and ingredient freshness.',
                    'Coordinate with other kitchen staff for timely service.',
                    'Adhere to station recipes and cooking techniques.',
                    'Maintain cleanliness and organization of the station.',
                    'Assist in station menu planning.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Sauce Chef',
                'responsibilities' => [
                    'Prepare sauces and gravies for dishes.',
                    'Maintain sauce consistency and flavor.',
                    'Coordinate sauce preparation with menu items.',
                    'Ensure proper storage and handling of sauces.',
                    'Collaborate with kitchen team for service.',
                    'Follow sauce recipes and quality standards.',
                    'Monitor sauce inventory and reorder as needed.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Pastry Chef',
                'responsibilities' => [
                    'Create and bake pastries and desserts.',
                    'Decorate and present desserts attractively.',
                    'Develop new pastry recipes and designs.',
                    'Manage pastry kitchen operations and staff.',
                    'Maintain inventory of pastry ingredients.',
                    'Ensure food safety in pastry preparation.',
                    'Collaborate with other kitchen sections for desserts.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Butcher Chef',
                'responsibilities' => [
                    'Prepare and cut meat for kitchen use.',
                    'Ensure meat quality and freshness.',
                    'Maintain meat storage and inventory.',
                    'Coordinate with kitchen staff for meat orders.',
                    'Follow meat cutting and handling standards.',
                    'Clean and sanitize meat-cutting equipment.',
                    'Assist in menu planning for meat dishes.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Fish Chef',
                'responsibilities' => [
                    'Prepare and cook fish dishes.',
                    'Ensure fish quality and proper handling.',
                    'Coordinate with kitchen team for fish items.',
                    'Maintain fish station cleanliness and organization.',
                    'Adhere to fish recipes and cooking techniques.',
                    'Monitor fish inventory and freshness.',
                    'Assist in menu planning for fish options.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Vegetable Chef',
                'responsibilities' => [
                    'Prepare and cook vegetable dishes.',
                    'Ensure vegetable quality and freshness.',
                    'Coordinate with kitchen staff for vegetable items.',
                    'Maintain vegetable station cleanliness and organization.',
                    'Adhere to vegetable recipes and cooking techniques.',
                    'Monitor vegetable inventory and freshness.',
                    'Assist in menu planning for vegetable options.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Pantry Chef (Garde Manger)',
                'responsibilities' => [
                    'Prepare cold dishes and appetizers.',
                    'Create and garnish salads and cold platters.',
                    'Maintain pantry station cleanliness and organization.',
                    'Coordinate with other kitchen sections for cold items.',
                    'Follow pantry recipes and presentation standards.',
                    'Monitor pantry inventory and freshness.',
                    'Assist in menu planning for cold options.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Grill Chef (Grillardin)',
                'responsibilities' => [
                    'Cook grilled dishes to order.',
                    'Maintain grill station cleanliness and safety.',
                    'Coordinate with kitchen team for grill items.',
                    'Adhere to grilling techniques and recipes.',
                    'Monitor grill inventory and temperature.',
                    'Assist in menu planning for grilled options.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Chief Steward',
                'responsibilities' => [
                    'Supervise dishwashing and kitchen cleaning staff.',
                    'Ensure cleanliness and sanitation in the kitchen.',
                    'Manage dishwashing equipment and supplies.',
                    'Coordinate with kitchen and service teams.',
                    'Maintain inventory of cleaning materials.',
                    'Train and schedule stewarding staff.',
                    'Monitor waste disposal and recycling efforts.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Kitchen Steward',
                'responsibilities' => [
                    'Wash and sanitize kitchen utensils and equipment.',
                    'Assist in maintaining kitchen cleanliness.',
                    'Collect and dispose of kitchen waste.',
                    'Help with inventory control and stock rotation.',
                    'Follow food safety and sanitation guidelines.',
                    'Support kitchen staff with various tasks.',
                    'Report maintenance issues to the chief steward.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Day Security Guard',
                'responsibilities' => [
                    'Monitor and control access to the premises.',
                    'Conduct security checks and inspections.',
                    'Respond to emergencies and incidents.',
                    'Maintain a visible and vigilant presence.',
                    'Assist guests and employees as needed.',
                    'Report security breaches and safety hazards.',
                    'Follow security protocols and procedures.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Head of Security',
                'responsibilities' => [
                    'Manage the security team and operations.',
                    'Develop and implement security policies and procedures.',
                    'Conduct security assessments and risk analysis.',
                    'Coordinate with law enforcement agencies.',
                    'Respond to major security incidents.',
                    'Maintain security equipment and systems.',
                    'Ensure compliance with security regulations.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Night Security Guard',
                'responsibilities' => [
                    'Patrol and secure the premises during nighttime.',
                    'Monitor surveillance cameras and alarms.',
                    'Respond to security breaches and alarms.',
                    'Assist guests and employees during late hours.',
                    'Complete security reports and logs.',
                    'Ensure a quiet and safe environment during the night.',
                    'Follow nighttime security protocols.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'General Manager',
                'responsibilities' => [
                    'Oversee all hotel operations and departments.',
                    'Set and implement hotel policies and strategies.',
                    'Manage budgets, financial performance, and revenue.',
                    'Ensure exceptional guest experiences and satisfaction.',
                    'Lead and motivate the hotel team.',
                    'Build and maintain relationships with stakeholders.',
                    'Address guest concerns and complaints.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Operations Manager',
                'responsibilities' => [
                    'Manage daily hotel operations and staff.',
                    'Ensure efficient and smooth guest services.',
                    'Monitor and improve hotel service quality.',
                    'Coordinate with department heads.',
                    'Manage budgets and expenses.',
                    'Implement hotel policies and procedures.',
                    'Report to the general manager.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
            [
                'designation' => 'Human Resource Manager',
                'responsibilities' => [
                    'Manage human resource functions and staff.',
                    'Recruit, train, and develop hotel employees.',
                    'Administer HR policies and procedures.',
                    'Handle employee relations and conflict resolution.',
                    'Manage payroll and benefits programs.',
                    'Ensure HR compliance with labor laws.',
                    'Support staff performance evaluations.',
                    'Any other duties allocated to you within the capacity of your department.',
                ],
            ],
        ];

        foreach ($designationResponsibilities as $data) {
            $designationId = DB::table('designations')
                ->where('title', $data['designation'])
                ->value('id');

            if ($designationId) {
                $responsibilities = $data['responsibilities'];

                foreach ($responsibilities as $responsibility) {
                    DB::table('responsibilities')->insert([
                        'designation_id' => $designationId,
                        'responsibility' => $responsibility,
                        'created_by' => 1,
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsibilities');
    }
};
