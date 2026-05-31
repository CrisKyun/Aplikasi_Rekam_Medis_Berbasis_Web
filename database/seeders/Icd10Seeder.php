<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Icd10Seeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Infectious & Parasitic
            ['kode' => 'A00', 'nama' => 'Cholera', 'kategori' => 'Infectious & Parasitic'],
            ['kode' => 'A01', 'nama' => 'Typhoid and paratyphoid fevers', 'kategori' => 'Infectious & Parasitic'],
            ['kode' => 'A09', 'nama' => 'Diarrhoea and gastroenteritis', 'kategori' => 'Infectious & Parasitic'],
            ['kode' => 'A15', 'nama' => 'Respiratory tuberculosis', 'kategori' => 'Infectious & Parasitic'],
            ['kode' => 'A90', 'nama' => 'Dengue fever', 'kategori' => 'Infectious & Parasitic'],
            ['kode' => 'A91', 'nama' => 'Dengue haemorrhagic fever', 'kategori' => 'Infectious & Parasitic'],
            ['kode' => 'B01', 'nama' => 'Varicella (chickenpox)', 'kategori' => 'Infectious & Parasitic'],
            ['kode' => 'B05', 'nama' => 'Measles', 'kategori' => 'Infectious & Parasitic'],
            ['kode' => 'B34', 'nama' => 'Viral infection of unspecified site', 'kategori' => 'Infectious & Parasitic'],

            // Neoplasms
            ['kode' => 'C00', 'nama' => 'Malignant neoplasm of lip', 'kategori' => 'Neoplasms'],
            ['kode' => 'C34', 'nama' => 'Malignant neoplasm of bronchus and lung', 'kategori' => 'Neoplasms'],
            ['kode' => 'C50', 'nama' => 'Malignant neoplasm of breast', 'kategori' => 'Neoplasms'],

            // Blood & Immune
            ['kode' => 'D50', 'nama' => 'Iron deficiency anaemia', 'kategori' => 'Blood & Immune'],
            ['kode' => 'D64', 'nama' => 'Other anaemias', 'kategori' => 'Blood & Immune'],

            // Endocrine & Metabolic
            ['kode' => 'E10', 'nama' => 'Type 1 diabetes mellitus', 'kategori' => 'Endocrine & Metabolic'],
            ['kode' => 'E11', 'nama' => 'Type 2 diabetes mellitus', 'kategori' => 'Endocrine & Metabolic'],
            ['kode' => 'E14', 'nama' => 'Unspecified diabetes mellitus', 'kategori' => 'Endocrine & Metabolic'],
            ['kode' => 'E03', 'nama' => 'Other hypothyroidism', 'kategori' => 'Endocrine & Metabolic'],
            ['kode' => 'E05', 'nama' => 'Thyrotoxicosis (hyperthyroidism)', 'kategori' => 'Endocrine & Metabolic'],
            ['kode' => 'E66', 'nama' => 'Obesity', 'kategori' => 'Endocrine & Metabolic'],
            ['kode' => 'E78', 'nama' => 'Disorders of lipoprotein metabolism (cholesterol)', 'kategori' => 'Endocrine & Metabolic'],

            // Mental & Behavioural
            ['kode' => 'F32', 'nama' => 'Depressive episode', 'kategori' => 'Mental & Behavioural'],
            ['kode' => 'F41', 'nama' => 'Other anxiety disorders', 'kategori' => 'Mental & Behavioural'],
            ['kode' => 'F10', 'nama' => 'Mental disorders due to alcohol use', 'kategori' => 'Mental & Behavioural'],

            // Nervous System
            ['kode' => 'G43', 'nama' => 'Migraine', 'kategori' => 'Nervous System'],
            ['kode' => 'G44', 'nama' => 'Other headache syndromes', 'kategori' => 'Nervous System'],
            ['kode' => 'G40', 'nama' => 'Epilepsy', 'kategori' => 'Nervous System'],

            // Eye
            ['kode' => 'H10', 'nama' => 'Conjunctivitis', 'kategori' => 'Eye'],
            ['kode' => 'H52', 'nama' => 'Disorders of refraction and accommodation', 'kategori' => 'Eye'],

            // Ear
            ['kode' => 'H65', 'nama' => 'Nonsuppurative otitis media', 'kategori' => 'Ear'],
            ['kode' => 'H66', 'nama' => 'Suppurative and unspecified otitis media', 'kategori' => 'Ear'],

            // Circulatory System
            ['kode' => 'I10', 'nama' => 'Essential (primary) hypertension', 'kategori' => 'Circulatory'],
            ['kode' => 'I11', 'nama' => 'Hypertensive heart disease', 'kategori' => 'Circulatory'],
            ['kode' => 'I20', 'nama' => 'Angina pectoris', 'kategori' => 'Circulatory'],
            ['kode' => 'I21', 'nama' => 'Acute myocardial infarction', 'kategori' => 'Circulatory'],
            ['kode' => 'I25', 'nama' => 'Chronic ischaemic heart disease', 'kategori' => 'Circulatory'],
            ['kode' => 'I50', 'nama' => 'Heart failure', 'kategori' => 'Circulatory'],
            ['kode' => 'I63', 'nama' => 'Cerebral infarction (stroke)', 'kategori' => 'Circulatory'],

            // Respiratory System
            ['kode' => 'J00', 'nama' => 'Acute nasopharyngitis (common cold)', 'kategori' => 'Respiratory'],
            ['kode' => 'J02', 'nama' => 'Acute pharyngitis', 'kategori' => 'Respiratory'],
            ['kode' => 'J03', 'nama' => 'Acute tonsillitis', 'kategori' => 'Respiratory'],
            ['kode' => 'J06', 'nama' => 'Acute upper respiratory infections', 'kategori' => 'Respiratory'],
            ['kode' => 'J11', 'nama' => 'Influenza, virus not identified', 'kategori' => 'Respiratory'],
            ['kode' => 'J18', 'nama' => 'Pneumonia, unspecified', 'kategori' => 'Respiratory'],
            ['kode' => 'J20', 'nama' => 'Acute bronchitis', 'kategori' => 'Respiratory'],
            ['kode' => 'J45', 'nama' => 'Asthma', 'kategori' => 'Respiratory'],

            // Digestive System
            ['kode' => 'K02', 'nama' => 'Dental caries', 'kategori' => 'Digestive'],
            ['kode' => 'K21', 'nama' => 'Gastro-oesophageal reflux disease (GERD)', 'kategori' => 'Digestive'],
            ['kode' => 'K25', 'nama' => 'Gastric ulcer', 'kategori' => 'Digestive'],
            ['kode' => 'K29', 'nama' => 'Gastritis and duodenitis', 'kategori' => 'Digestive'],
            ['kode' => 'K30', 'nama' => 'Functional dyspepsia', 'kategori' => 'Digestive'],
            ['kode' => 'K35', 'nama' => 'Acute appendicitis', 'kategori' => 'Digestive'],
            ['kode' => 'K59', 'nama' => 'Other functional intestinal disorders (constipation)', 'kategori' => 'Digestive'],

            // Skin
            ['kode' => 'L01', 'nama' => 'Impetigo', 'kategori' => 'Skin'],
            ['kode' => 'L20', 'nama' => 'Atopic dermatitis (eczema)', 'kategori' => 'Skin'],
            ['kode' => 'L23', 'nama' => 'Allergic contact dermatitis', 'kategori' => 'Skin'],
            ['kode' => 'L50', 'nama' => 'Urticaria (hives)', 'kategori' => 'Skin'],
            ['kode' => 'L70', 'nama' => 'Acne', 'kategori' => 'Skin'],

            // Musculoskeletal
            ['kode' => 'M05', 'nama' => 'Rheumatoid arthritis', 'kategori' => 'Musculoskeletal'],
            ['kode' => 'M10', 'nama' => 'Gout', 'kategori' => 'Musculoskeletal'],
            ['kode' => 'M54', 'nama' => 'Dorsalgia (back pain)', 'kategori' => 'Musculoskeletal'],
            ['kode' => 'M79', 'nama' => 'Other soft tissue disorders (myalgia)', 'kategori' => 'Musculoskeletal'],

            // Genitourinary
            ['kode' => 'N10', 'nama' => 'Acute pyelonephritis', 'kategori' => 'Genitourinary'],
            ['kode' => 'N18', 'nama' => 'Chronic kidney disease', 'kategori' => 'Genitourinary'],
            ['kode' => 'N30', 'nama' => 'Cystitis (urinary tract infection)', 'kategori' => 'Genitourinary'],
            ['kode' => 'N39', 'nama' => 'Other disorders of urinary system', 'kategori' => 'Genitourinary'],

            // Pregnancy
            ['kode' => 'O10', 'nama' => 'Pre-existing hypertension in pregnancy', 'kategori' => 'Pregnancy'],
            ['kode' => 'O24', 'nama' => 'Diabetes mellitus in pregnancy', 'kategori' => 'Pregnancy'],
            ['kode' => 'O80', 'nama' => 'Single spontaneous delivery', 'kategori' => 'Pregnancy'],

            // Symptoms & Signs
            ['kode' => 'R00', 'nama' => 'Abnormalities of heart beat', 'kategori' => 'Symptoms & Signs'],
            ['kode' => 'R05', 'nama' => 'Cough', 'kategori' => 'Symptoms & Signs'],
            ['kode' => 'R06', 'nama' => 'Abnormalities of breathing', 'kategori' => 'Symptoms & Signs'],
            ['kode' => 'R07', 'nama' => 'Pain in throat and chest', 'kategori' => 'Symptoms & Signs'],
            ['kode' => 'R10', 'nama' => 'Abdominal and pelvic pain', 'kategori' => 'Symptoms & Signs'],
            ['kode' => 'R11', 'nama' => 'Nausea and vomiting', 'kategori' => 'Symptoms & Signs'],
            ['kode' => 'R50', 'nama' => 'Fever of other and unknown origin', 'kategori' => 'Symptoms & Signs'],
            ['kode' => 'R51', 'nama' => 'Headache', 'kategori' => 'Symptoms & Signs'],
            ['kode' => 'R52', 'nama' => 'Pain, unspecified', 'kategori' => 'Symptoms & Signs'],
            ['kode' => 'R53', 'nama' => 'Malaise and fatigue', 'kategori' => 'Symptoms & Signs'],
            ['kode' => 'R55', 'nama' => 'Syncope and collapse (fainting)', 'kategori' => 'Symptoms & Signs'],
            ['kode' => 'R68', 'nama' => 'Other general symptoms and signs', 'kategori' => 'Symptoms & Signs'],

            // Injury
            ['kode' => 'S00', 'nama' => 'Superficial injury of head', 'kategori' => 'Injury'],
            ['kode' => 'S09', 'nama' => 'Other injuries of head', 'kategori' => 'Injury'],
            ['kode' => 'T14', 'nama' => 'Injury of unspecified body region', 'kategori' => 'Injury'],
            ['kode' => 'T78', 'nama' => 'Adverse effects (allergy / anaphylaxis)', 'kategori' => 'Injury'],

            // COVID & Respiratory Virus
            ['kode' => 'U07', 'nama' => 'COVID-19', 'kategori' => 'Special Purposes'],
            ['kode' => 'U09', 'nama' => 'Post-COVID-19 condition', 'kategori' => 'Special Purposes'],
        ];

        DB::table('icd10')->insert($data);
    }
}
