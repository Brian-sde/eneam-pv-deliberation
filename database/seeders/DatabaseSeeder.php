<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Filiere;
use App\Models\Level;
use App\Models\Promotion;
use App\Models\Pv;
use App\Models\PvStudentResult;
use App\Models\Semester;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with realistic ENEAM data.
     */
    public function run(): void
    {
        // 1. Utilisateurs de test avec profils d'acteurs de l'ENEAM
        $admin = User::firstOrCreate(
            ['email' => 'admin@eneam.uac.bj'],
            [
                'name' => 'Administrateur ENEAM',
                'password' => Hash::make('password'),
            ]
        );

        $scolarite = User::firstOrCreate(
            ['email' => 'scolarite@eneam.uac.bj'],
            [
                'name' => 'Agent Service Examens & Scolarité',
                'password' => Hash::make('password'),
            ]
        );

        $chefDept = User::firstOrCreate(
            ['email' => 'chef.ig@eneam.uac.bj'],
            [
                'name' => 'Dr. BIO - Chef Département Informatique',
                'password' => Hash::make('password'),
            ]
        );

        $enseignant = User::firstOrCreate(
            ['email' => 'enseignant@eneam.uac.bj'],
            [
                'name' => 'Prof. KPADONOU',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Années Académiques
        $year2223 = AcademicYear::firstOrCreate(
            ['code' => '2022-2023'],
            [
                'name' => 'Année Académique 2022-2023',
                'start_date' => '2022-10-01',
                'end_date' => '2023-07-31',
                'is_current' => false,
            ]
        );

        $year2324 = AcademicYear::firstOrCreate(
            ['code' => '2023-2024'],
            [
                'name' => 'Année Académique 2023-2024',
                'start_date' => '2023-10-01',
                'end_date' => '2024-07-31',
                'is_current' => false,
            ]
        );

        $year2425 = AcademicYear::firstOrCreate(
            ['code' => '2024-2025'],
            [
                'name' => 'Année Académique 2024-2025',
                'start_date' => '2024-10-01',
                'end_date' => '2025-07-31',
                'is_current' => true,
            ]
        );

        // 3. Filières officielles de l'ENEAM
        $filieresData = [
            [
                'code' => 'IG',
                'name' => 'Informatique de Gestion',
                'department' => 'Informatique et Mathématiques Appliquées',
                'description' => 'Formation en développement logiciel, systèmes d\'information et bases de données.'
            ],
            [
                'code' => 'SE',
                'name' => 'Statistique et Économétrie',
                'department' => 'Statistique et Démographie',
                'description' => 'Formation en analyse statistique, modélisation économétrique et data science.'
            ],
            [
                'code' => 'BF',
                'name' => 'Banque et Finance',
                'department' => 'Finance et Comptabilité',
                'description' => 'Gestion bancaire, marchés financiers et analyse de crédits.'
            ],
            [
                'code' => 'GRH',
                'name' => 'Gestion des Ressources Humaines',
                'department' => 'Management et Organisation',
                'description' => 'Recrutement, gestion des compétences et droit social.'
            ],
            [
                'code' => 'CCA',
                'name' => 'Comptabilité, Contrôle et Audit',
                'department' => 'Finance et Comptabilité',
                'description' => 'Expertise comptable, audit financier et contrôle de gestion.'
            ],
            [
                'code' => 'MK',
                'name' => 'Marketing et Action Commerciale',
                'department' => 'Commerce et Marketing',
                'description' => 'Stratégie commerciale, communication digitale et négociation.'
            ],
        ];

        $filieres = [];
        foreach ($filieresData as $data) {
            $filieres[$data['code']] = Filiere::firstOrCreate(['code' => $data['code']], $data);
        }

        // 4. Niveaux et Semestres LMD
        $levelsData = [
            ['code' => 'L1', 'name' => 'Licence 1ère Année', 'cycle' => 'Licence', 'order' => 1, 'semesters' => ['S1', 'S2']],
            ['code' => 'L2', 'name' => 'Licence 2ème Année', 'cycle' => 'Licence', 'order' => 2, 'semesters' => ['S3', 'S4']],
            ['code' => 'L3', 'name' => 'Licence 3ème Année', 'cycle' => 'Licence', 'order' => 3, 'semesters' => ['S5', 'S6']],
            ['code' => 'M1', 'name' => 'Master 1ère Année', 'cycle' => 'Master', 'order' => 4, 'semesters' => ['S1', 'S2']],
            ['code' => 'M2', 'name' => 'Master 2ème Année', 'cycle' => 'Master', 'order' => 5, 'semesters' => ['S3', 'S4']],
        ];

        $levels = [];
        $semesters = [];
        foreach ($levelsData as $ldata) {
            $level = Level::firstOrCreate(
                ['code' => $ldata['code']],
                [
                    'name' => $ldata['name'],
                    'cycle' => $ldata['cycle'],
                    'order' => $ldata['order'],
                ]
            );
            $levels[$ldata['code']] = $level;

            foreach ($ldata['semesters'] as $idx => $semCode) {
                $sem = Semester::firstOrCreate(
                    ['level_id' => $level->id, 'code' => $semCode],
                    [
                        'name' => 'Semestre ' . substr($semCode, 1),
                        'order' => $idx + 1,
                    ]
                );
                $semesters[$ldata['code'] . '-' . $semCode] = $sem;
            }
        }

        // 5. Promotions
        $promoIG_L2_2324 = Promotion::firstOrCreate(
            [
                'academic_year_id' => $year2324->id,
                'filiere_id' => $filieres['IG']->id,
                'level_id' => $levels['L2']->id,
            ],
            ['name' => 'Promotion 2023-2024 - L2 Informatique de Gestion']
        );

        $promoIG_L3_2324 = Promotion::firstOrCreate(
            [
                'academic_year_id' => $year2324->id,
                'filiere_id' => $filieres['IG']->id,
                'level_id' => $levels['L3']->id,
            ],
            ['name' => 'Promotion 2023-2024 - L3 Informatique de Gestion']
        );

        $promoBF_L2_2324 = Promotion::firstOrCreate(
            [
                'academic_year_id' => $year2324->id,
                'filiere_id' => $filieres['BF']->id,
                'level_id' => $levels['L2']->id,
            ],
            ['name' => 'Promotion 2023-2024 - L2 Banque et Finance']
        );

        // 6. Étudiants
        $studentsData = [
            ['matricule' => '2022-IG-001', 'last_name' => 'ADANHOUNME', 'first_name' => 'Kévin', 'gender' => 'M', 'birth_date' => '2003-04-12', 'email' => 'kevin.ad@etud.uac.bj'],
            ['matricule' => '2022-IG-002', 'last_name' => 'HOUNNOU', 'first_name' => 'Boris', 'gender' => 'M', 'birth_date' => '2002-09-24', 'email' => 'boris.ho@etud.uac.bj'],
            ['matricule' => '2022-IG-003', 'last_name' => 'DOSSOU', 'first_name' => 'Estelle', 'gender' => 'F', 'birth_date' => '2004-01-18', 'email' => 'estelle.do@etud.uac.bj'],
            ['matricule' => '2022-IG-004', 'last_name' => 'MENSAH', 'first_name' => 'Christian', 'gender' => 'M', 'birth_date' => '2003-11-05', 'email' => 'christian.me@etud.uac.bj'],
            ['matricule' => '2022-IG-005', 'last_name' => 'AGBODJALOU', 'first_name' => 'Grâce', 'gender' => 'F', 'birth_date' => '2004-06-30', 'email' => 'grace.ag@etud.uac.bj'],
            ['matricule' => '2022-IG-006', 'last_name' => 'SOGLO', 'first_name' => 'Patrice', 'gender' => 'M', 'birth_date' => '2002-12-14', 'email' => 'patrice.so@etud.uac.bj'],
            ['matricule' => '2022-IG-007', 'last_name' => 'KOUASSI', 'first_name' => 'Mariette', 'gender' => 'F', 'birth_date' => '2003-08-21', 'email' => 'mariette.ko@etud.uac.bj'],
            ['matricule' => '2022-IG-008', 'last_name' => 'TOSSOU', 'first_name' => 'Fabrice', 'gender' => 'M', 'birth_date' => '2003-03-09', 'email' => 'fabrice.to@etud.uac.bj'],
        ];

        $students = [];
        foreach ($studentsData as $sdata) {
            $students[] = Student::firstOrCreate(['matricule' => $sdata['matricule']], $sdata);
        }

        // 7. PV de Délibération (Session Normale S3 - L2 IG)
        $pvS3 = Pv::firstOrCreate(
            ['reference' => 'PV-2024-IG-L2-S3-NORM'],
            [
                'promotion_id' => $promoIG_L2_2324->id,
                'semester_id' => $semesters['L2-S3']->id,
                'session' => 'normale',
                'deliberation_date' => '2024-02-15',
                'jury_president' => 'Dr. BIO (Maître de Conférences)',
                'jury_members' => [
                    'Prof. KPADONOU (Examinateur principal)',
                    'Dr. ZANNOU (Rapporteur)',
                    'M. TCHIKPE (Secrétaire de séance)'
                ],
                'file_path' => 'pvs/scans/pv_2024_ig_l2_s3_norm.pdf',
                // Hash SHA-256 d'exemple pour simuler le scellement cryptographique
                'file_hash_sha256' => hash('sha256', 'PV-2024-IG-L2-S3-NORM-DEMO-FILE-ENEAM'),
                'status' => 'validated',
                'observations' => 'Délibération déroulée conformément aux dispositions du régime LMD de l\'ENEAM.',
                'created_by' => $scolarite->id,
                'validated_by' => $chefDept->id,
                'validated_at' => '2024-02-16 10:30:00',
            ]
        );

        // 8. Résultats des étudiants pour le PV S3
        $resultsData = [
            ['student_idx' => 0, 'average' => 15.75, 'credits' => 30, 'decision' => 'admis', 'rank' => 1, 'mention' => 'Bien'],
            ['student_idx' => 1, 'average' => 14.20, 'credits' => 30, 'decision' => 'admis', 'rank' => 2, 'mention' => 'Bien'],
            ['student_idx' => 2, 'average' => 13.80, 'credits' => 30, 'decision' => 'admis', 'rank' => 3, 'mention' => 'Assez Bien'],
            ['student_idx' => 3, 'average' => 12.45, 'credits' => 30, 'decision' => 'admis', 'rank' => 4, 'mention' => 'Assez Bien'],
            ['student_idx' => 4, 'average' => 11.50, 'credits' => 30, 'decision' => 'admis', 'rank' => 5, 'mention' => 'Passable'],
            ['student_idx' => 5, 'average' => 10.25, 'credits' => 30, 'decision' => 'compense', 'rank' => 6, 'mention' => 'Passable'],
            ['student_idx' => 6, 'average' => 9.40, 'credits' => 22, 'decision' => 'rattrapage', 'rank' => 7, 'mention' => null],
            ['student_idx' => 7, 'average' => 7.80, 'credits' => 14, 'decision' => 'ajourne', 'rank' => 8, 'mention' => null],
        ];

        foreach ($resultsData as $res) {
            PvStudentResult::firstOrCreate(
                [
                    'pv_id' => $pvS3->id,
                    'student_id' => $students[$res['student_idx']]->id,
                ],
                [
                    'average' => $res['average'],
                    'credits_earned' => $res['credits'],
                    'decision' => $res['decision'],
                    'rank' => $res['rank'],
                    'mention' => $res['mention'],
                ]
            );
        }

        // 9. Un deuxième PV pour le Semestre 4 (L2 IG)
        $pvS4 = Pv::firstOrCreate(
            ['reference' => 'PV-2024-IG-L2-S4-NORM'],
            [
                'promotion_id' => $promoIG_L2_2324->id,
                'semester_id' => $semesters['L2-S4']->id,
                'session' => 'normale',
                'deliberation_date' => '2024-07-12',
                'jury_president' => 'Dr. BIO',
                'jury_members' => ['Prof. KPADONOU', 'Dr. ZANNOU'],
                'file_path' => 'pvs/scans/pv_2024_ig_l2_s4_norm.pdf',
                'file_hash_sha256' => hash('sha256', 'PV-2024-IG-L2-S4-NORM-DEMO-FILE-ENEAM'),
                'status' => 'validated',
                'created_by' => $scolarite->id,
                'validated_by' => $chefDept->id,
                'validated_at' => '2024-07-13 14:00:00',
            ]
        );

        // 10. Un troisième PV en mode "Brouillon" pour tester le workflow de validation
        Pv::firstOrCreate(
            ['reference' => 'PV-2024-BF-L2-S3-NORM'],
            [
                'promotion_id' => $promoBF_L2_2324->id,
                'semester_id' => $semesters['L2-S3']->id,
                'session' => 'normale',
                'deliberation_date' => '2024-02-20',
                'jury_president' => 'Dr. AGBANGLA',
                'jury_members' => ['Mme. HOUNWANOU'],
                'status' => 'draft',
                'created_by' => $scolarite->id,
            ]
        );
    }
}
