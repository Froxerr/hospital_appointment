<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\AddressState;
use Illuminate\Database\Seeder;
use PHPUnit\TextUI\Configuration\VariableCollectionIterator;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this -> call([
            AddresseCitySeeders::class,
            AddresseDistrictSeeders::class,
            AddresseSeeder::class,
            InsuranceTypesSeeders::class,
            InsurancesSeeders::class,
            PatientSeeders::class,
            HospitalAppointmentFloorSeeders::class,
            SpecialtiesSeeders::class,
            DoctorSeeders::class,
            NurseSeeders::class,
            HospitalAppointmentSeeders::class,
            AppointmentHistorySeeders::class,
            AppointmentCapacitiesSeeders::class,
            VaccineSeeders::class,
            VaccineAppointmentSeeders::class,
            RoleSeeders::class,
            UserSeeders::class,
            LogRecordSeeders::class,
            DoctorTimeOffSeeders::class,
            DoctorSchedulesSeeders::class,
            NurseTimeOffSeeders::class,
            NurseSchedulesSeeders::class,
            PageSeeders::class,
            ContactSeeders::class
        ]);
    }
}
