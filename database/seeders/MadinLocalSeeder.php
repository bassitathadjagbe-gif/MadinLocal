<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MadinLocalSeeder extends Seeder
{
    public function run(): void
    {
        // Vider les tables existantes (dans l'ordre pour respecter les clés étrangères)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('paiements')->truncate(); 
        DB::table('evaluations')->truncate();
        DB::table('favoris')->truncate();
        DB::table('commandes')->truncate();
        DB::table('notifications')->truncate();
        DB::table('produits')->truncate();
        DB::table('categories')->truncate();
        DB::table('investisseurs')->truncate();
        DB::table('artisans')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        echo "\n🌱 Début du seeding MadinLocal...\n\n";

        // ============================================
        // 1. ADMIN
        // ============================================
        echo "👑 Création de l'admin...\n";
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin MadinLocal',
            'email' => 'admin@madinlocal.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'telephone' => '+229 97 00 00 00',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ============================================
        // 2. CLIENTS
        // ============================================
        echo "👤 Création des clients...\n";
        $clientsData = [
            ['name' => 'Marie Dossou', 'email' => 'marie@example.com', 'telephone' => '+229 95 12 34 56'],
            ['name' => 'Jean Houngbo', 'email' => 'jean@example.com', 'telephone' => '+229 96 23 45 67'],
            ['name' => 'Aïcha Boko', 'email' => 'aicha@example.com', 'telephone' => '+229 97 34 56 78'],
            ['name' => 'Patrick Agossou', 'email' => 'patrick@example.com', 'telephone' => '+229 94 45 67 89'],
            ['name' => 'Sophia Adjakly', 'email' => 'sophia@example.com', 'telephone' => '+229 95 56 78 90'],
        ];

        $clientIds = [];
        foreach ($clientsData as $client) {
            $clientIds[] = DB::table('users')->insertGetId([
                'name' => $client['name'],
                'email' => $client['email'],
                'password' => Hash::make('password'),
                'role' => 'client',
                'telephone' => $client['telephone'],
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ============================================
        // 3. ARTISANS
        // ============================================
        echo "🎨 Création des artisans...\n";
        $artisansData = [
            ['name' => 'Koffi Adjaho', 'email' => 'koffi@example.com', 'specialite' => 'Menuiserie', 'ville' => 'Cotonou', 'telephone' => '+229 95 11 22 33', 'description' => 'Menuisier passionné, je crée des meubles uniques en bois précieux du Bénin.', 'nom_entreprise' => 'Atelier Koffi Menuiserie'],
            ['name' => 'Akossiwa Mensah', 'email' => 'akossiwa@example.com', 'specialite' => 'Couture et textile', 'ville' => 'Abomey', 'telephone' => '+229 96 22 33 44', 'description' => 'Couturière talentueuse, je confectionne des vêtements traditionnels et modernes.', 'nom_entreprise' => 'Les Couturières d\'Abomey'],
            ['name' => 'Dagbé Soglo', 'email' => 'dagbe@example.com', 'specialite' => 'Poterie-céramique', 'ville' => 'Ouidah', 'telephone' => '+229 97 33 44 55', 'description' => 'Potier traditionnel, mes créations allient esthétique et utilité.', 'nom_entreprise' => 'Poterie Traditionnelle de Ouidah'],
            ['name' => 'Essè Gbedo', 'email' => 'esse@example.com', 'specialite' => 'Bijoux', 'ville' => 'Porto-Novo', 'telephone' => '+229 94 44 55 66', 'description' => 'Créatrice de bijoux artisanaux inspirés de la culture béninoise.', 'nom_entreprise' => 'Bijoux Essè'],
            ['name' => 'Hounsa Ayayi', 'email' => 'hounsa@example.com', 'specialite' => 'Vannerie', 'ville' => 'Parakou', 'telephone' => '+229 95 55 66 77', 'description' => 'Artisan vannier, je fabrique paniers et objets tressés en fibres naturelles.', 'nom_entreprise' => 'Vannerie de Parakou'],
        ];

        $artisanUserIds = [];
        $artisanIds = [];
        foreach ($artisansData as $artisan) {
            $userId = DB::table('users')->insertGetId([
                'name' => $artisan['name'],
                'email' => $artisan['email'],
                'password' => Hash::make('password'),
                'role' => 'artisan',
                'telephone' => $artisan['telephone'],
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $artisanUserIds[] = $userId;

            $artisanIds[] = DB::table('artisans')->insertGetId([
                'user_id' => $userId,
                'nom_entreprise' => $artisan['nom_entreprise'],
                'specialite' => $artisan['specialite'],
                'ville' => $artisan['ville'],
                'description' => $artisan['description'],
                'is_approved' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ============================================
        // 4. INVESTISSEURS
        // ============================================
        echo "💼 Création des investisseurs...\n";
        $investisseursData = [
            ['name' => 'Bénin Capital', 'email' => 'contact@benincapital.com', 'entreprise' => 'Bénin Capital SARL', 'type' => 'Capital', 'telephone' => '+229 97 00 11 22'],
            ['name' => 'InvestArt Group', 'email' => 'info@investart.com', 'entreprise' => 'InvestArt Group', 'type' => 'Mixte', 'telephone' => '+229 96 00 33 44'],
        ];

        $investisseurUserIds = [];
        foreach ($investisseursData as $inv) {
            $userId = DB::table('users')->insertGetId([
                'name' => $inv['name'],
                'email' => $inv['email'],
                'password' => Hash::make('password'),
                'role' => 'investisseur',
                'telephone' => $inv['telephone'],
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $investisseurUserIds[] = $userId;

            DB::table('investisseurs')->insert([
                'user_id' => $userId,
                'entreprise' => $inv['entreprise'],
                'type_investissement' => $inv['type'],
                'budget_min' => 500000,
                'budget_max' => 5000000,
                'description' => 'Nous investissons dans l\'artisanat local pour promouvoir le savoir-faire béninois.',
                'is_approved' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ============================================
        // 5. CATÉGORIES
        // ============================================
        echo "📂 Création des catégories...\n";
        $categoriesData = [
            ['nom' => 'Couture et textile', 'description' => 'Vêtements, tissus, accessoires textiles et articles de couture'],
            ['nom' => 'Menuiserie', 'description' => 'Meubles, objets en bois et travaux de menuiserie artisanale'],
            ['nom' => 'Art et Décoration', 'description' => 'Œuvres artistiques, objets décoratifs et sculptures'],
            ['nom' => 'Bijoux', 'description' => 'Bijoux artisanaux, parures et accessoires de mode'],
            ['nom' => 'Agroalimentaire', 'description' => 'Produits alimentaires transformés artisanalement'],
            ['nom' => 'Coiffure et Beauté', 'description' => 'Services de coiffure, soins esthétiques et produits de beauté'],
            ['nom' => 'Poterie-céramique', 'description' => 'Vases, bols, objets en terre cuite et céramique'],
            ['nom' => 'Vannerie', 'description' => 'Paniers, objets tressés en osier, rotin et fibres naturelles'],
        ];

        $categoryIds = [];
        foreach ($categoriesData as $cat) {
            $categoryIds[] = DB::table('categories')->insertGetId([
                'nom' => $cat['nom'],
                'slug' => Str::slug($cat['nom']),
                'description' => $cat['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo "   ✅ " . count($categoryIds) . " catégories créées\n";

        // ============================================
        // 6. PRODUITS
        // ============================================
        echo "🛍️ Création des produits...\n";
        $produits = [
            // ===== COUTURE ET TEXTILE (Catégorie 1) =====
            ['nom' => 'Pagne traditionnel wax', 'description' => 'Pagne wax authentique aux motifs colorés, tissu de haute qualité.', 'prix' => 8000, 'artisan_id' => $artisanIds[1], 'category_id' => $categoryIds[0]],
            ['nom' => 'Robe en pagne africain', 'description' => 'Robe longue confectionnée à la main en pagne wax traditionnel.', 'prix' => 25000, 'artisan_id' => $artisanIds[1], 'category_id' => $categoryIds[0]],
            ['nom' => 'Sac en tissu africain', 'description' => 'Sac à main élégant fabriqué avec du tissu wax et doublure en coton.', 'prix' => 15000, 'artisan_id' => $artisanIds[1], 'category_id' => $categoryIds[0]],
            ['nom' => 'Ensemble chemise et pantalon', 'description' => 'Tenue complète pour homme en tissu traditionnel béninois.', 'prix' => 35000, 'artisan_id' => $artisanIds[1], 'category_id' => $categoryIds[0]],

            // ===== MENUISERIE (Catégorie 2) =====
            ['nom' => 'Table basse en bois d\'iroko', 'description' => 'Table artisanale sculptée en bois massif d\'iroko, finition vernie.', 'prix' => 75000, 'artisan_id' => $artisanIds[0], 'category_id' => $categoryIds[1]],
            ['nom' => 'Chaise traditionnelle sculptée', 'description' => 'Chaise en bois sculpté avec motifs traditionnels béninois.', 'prix' => 45000, 'artisan_id' => $artisanIds[0], 'category_id' => $categoryIds[1]],
            ['nom' => 'Armoire en bois massif', 'description' => 'Grande armoire à 2 portes en bois rouge, fabrication artisanale.', 'prix' => 120000, 'artisan_id' => $artisanIds[0], 'category_id' => $categoryIds[1]],
            ['nom' => 'Étagère murale décorative', 'description' => 'Étagère en bois avec sculptures géométriques, idéale pour la décoration.', 'prix' => 30000, 'artisan_id' => $artisanIds[0], 'category_id' => $categoryIds[1]],

            // ===== ART ET DÉCORATION (Catégorie 3) =====
            ['nom' => 'Masque Gèlèdè', 'description' => 'Masque traditionnel Yoruba sculpté en bois, pièce unique de collection.', 'prix' => 55000, 'artisan_id' => $artisanIds[0], 'category_id' => $categoryIds[2]],
            ['nom' => 'Tableau en tissu appliqué', 'description' => 'Œuvre d\'art en tissu appliqué représentant une scène de vie villageoise.', 'prix' => 40000, 'artisan_id' => $artisanIds[1], 'category_id' => $categoryIds[2]],
            ['nom' => 'Statue en bois d\'ébène', 'description' => 'Statue sculptée représentant un ancêtre, bois d\'ébène poli.', 'prix' => 65000, 'artisan_id' => $artisanIds[0], 'category_id' => $categoryIds[2]],
            ['nom' => 'Miroir cadre sculpté', 'description' => 'Miroir décoratif avec cadre en bois sculpté de motifs traditionnels.', 'prix' => 35000, 'artisan_id' => $artisanIds[0], 'category_id' => $categoryIds[2]],

            // ===== BIJOUX (Catégorie 4) =====
            ['nom' => 'Collier de perles multicolores', 'description' => 'Collier artisanal en perles de verre recyclées, couleurs vives.', 'prix' => 12000, 'artisan_id' => $artisanIds[3], 'category_id' => $categoryIds[3]],
            ['nom' => 'Bracelet en cauris', 'description' => 'Bracelet traditionnel orné de cauris naturels et perles.', 'prix' => 8000, 'artisan_id' => $artisanIds[3], 'category_id' => $categoryIds[3]],
            ['nom' => 'Boucles d\'oreilles en laiton', 'description' => 'Boucles d\'oreilles forgées en laiton avec motifs géométriques.', 'prix' => 10000, 'artisan_id' => $artisanIds[3], 'category_id' => $categoryIds[3]],
            ['nom' => 'Bague en argent massif', 'description' => 'Bague artisanale en argent 925 avec gravure traditionnelle.', 'prix' => 18000, 'artisan_id' => $artisanIds[3], 'category_id' => $categoryIds[3]],

            // ===== AGROALIMENTAIRE (Catégorie 5) =====
            ['nom' => 'Miel pur de ruche', 'description' => 'Miel naturel 100% pur, récolté artisanalement dans le nord du Bénin.', 'prix' => 5000, 'artisan_id' => $artisanIds[2], 'category_id' => $categoryIds[4]],
            ['nom' => 'Beurre de karité bio', 'description' => 'Beurre de karité raffiné traditionnellement, qualité cosmétique et alimentaire.', 'prix' => 3000, 'artisan_id' => $artisanIds[2], 'category_id' => $categoryIds[4]],
            ['nom' => 'Piment séché en poudre', 'description' => 'Piment rouge séché et moulu artisanalement, saveur authentique.', 'prix' => 2000, 'artisan_id' => $artisanIds[2], 'category_id' => $categoryIds[4]],
            ['nom' => 'Huile de palme rouge', 'description' => 'Huile de palme traditionnelle pressée à froid, riche en vitamine A.', 'prix' => 4000, 'artisan_id' => $artisanIds[2], 'category_id' => $categoryIds[4]],

            // ===== POTERIE-CÉRAMIQUE (Catégorie 7) =====
            ['nom' => 'Canari traditionnel', 'description' => 'Grand pot en terre cuite pour conserver l\'eau fraîche naturellement.', 'prix' => 15000, 'artisan_id' => $artisanIds[2], 'category_id' => $categoryIds[6]],
            ['nom' => 'Ensemble de bols décoratifs', 'description' => 'Lot de 3 bols en céramique peints à la main avec motifs traditionnels.', 'prix' => 12000, 'artisan_id' => $artisanIds[2], 'category_id' => $categoryIds[6]],
            ['nom' => 'Vase en terre cuite', 'description' => 'Vase décoratif en terre cuite, finition naturelle, hauteur 30cm.', 'prix' => 18000, 'artisan_id' => $artisanIds[2], 'category_id' => $categoryIds[6]],
            ['nom' => 'Plat de service en céramique', 'description' => 'Grand plat ovale en céramique émaillée, idéal pour les repas familiaux.', 'prix' => 20000, 'artisan_id' => $artisanIds[2], 'category_id' => $categoryIds[6]],

            // ===== VANNERIE (Catégorie 8) =====
            ['nom' => 'Panier en osier tressé', 'description' => 'Grand panier en osier naturel tressé à la main, avec couvercle.', 'prix' => 10000, 'artisan_id' => $artisanIds[4], 'category_id' => $categoryIds[7]],
            ['nom' => 'Corbeille de rangement', 'description' => 'Corbeille décorative en rotin tressé, parfaite pour ranger le linge.', 'prix' => 8000, 'artisan_id' => $artisanIds[4], 'category_id' => $categoryIds[7]],
            ['nom' => 'Plateau en vannerie', 'description' => 'Plateau de service en fibres naturelles tressées, finition vernie.', 'prix' => 6000, 'artisan_id' => $artisanIds[4], 'category_id' => $categoryIds[7]],
            ['nom' => 'Natte en paille tressée', 'description' => 'Natte traditionnelle tressée à la main, idéale pour la décoration ou la détente.', 'prix' => 15000, 'artisan_id' => $artisanIds[4], 'category_id' => $categoryIds[7]],
        ];

        $produitIds = [];
        foreach ($produits as $prod) {
            $produitIds[] = DB::table('produits')->insertGetId([
                'nom' => $prod['nom'],
                'description' => $prod['description'],
                'prix' => $prod['prix'],
                'type' => 'produit',
                'stock' => rand(3, 15),
                'images' => json_encode(['https://picsum.photos/seed/' . Str::slug($prod['nom']) . '/400/400']),
                'category_id' => $prod['category_id'],
                'artisan_id' => $prod['artisan_id'],
                'is_validated' => 1,
                'is_published' => 1,
                'is_rejected' => 0,
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now(),
            ]);
        }

        echo "   ✅ " . count($produitIds) . " produits créés\n";

        // ============================================
        // 7. COMMANDES + PAIEMENTS + ÉVALUATIONS
        // ============================================
        echo "🛒 Création des commandes, paiements et évaluations...\n";
        $statuts = ['terminee', 'terminee', 'terminee', 'acceptee', 'payee', 'en_cours', 'en_attente', 'terminee'];
        $methodes = ['mobile_money', 'mobile_money', 'carte_bancaire', 'paiement_livraison'];
        $operateurs = ['MTN', 'Moov', 'MTN', 'Moov'];

        for ($i = 0; $i < 25; $i++) {
            $clientId = $clientIds[array_rand($clientIds)];
            $prodIndex = array_rand($produits);
            $produitId = $produitIds[$prodIndex];
            $prodData = $produits[$prodIndex];
            $quantite = rand(1, 3);
            $montantTotal = $prodData['prix'] * $quantite;
            $statut = $statuts[array_rand($statuts)];

            // Créer la commande
            $commandeId = DB::table('commandes')->insertGetId([
                'client_id' => $clientId,
                'produit_id' => $produitId,
                'artisan_id' => $prodData['artisan_id'],
                'quantite' => $quantite,
                'montant_total' => $montantTotal,
                'statut' => $statut,
                'created_at' => now()->subDays(rand(1, 45)),
                'updated_at' => now(),
            ]);

            // Créer un paiement pour les commandes acceptées, payées ou terminées
            if (in_array($statut, ['acceptee', 'payee', 'en_cours', 'terminee'])) {
                $methode = $methodes[array_rand($methodes)];
                DB::table('paiements')->insert([
                    'commande_id' => $commandeId,
                    'client_id' => $clientId,
                    'montant' => $montantTotal,
                    'methode' => $methode,
                    'statut' => 'reussi',
                    'reference' => 'PAY-' . strtoupper(Str::random(10)),
                    'operateur' => in_array($methode, ['mobile_money']) ? $operateurs[array_rand($operateurs)] : null,
                    'numero_transaction' => 'TXN-' . time() . rand(100, 999),
                    'details' => json_encode(['methode' => $methode]),
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
            }

            // Créer une évaluation pour les commandes terminées
            if ($statut === 'terminee') {
                DB::table('evaluations')->insert([
                    'commande_id' => $commandeId,
                    'client_id' => $clientId,
                    'artisan_id' => $prodData['artisan_id'],
                    'note' => rand(3, 5),
                    'commentaire' => $this->randomCommentaire(),
                    'created_at' => now()->subDays(rand(1, 15)),
                    'updated_at' => now(),
                ]);
            }
        }

        // ============================================
        // 8. FAVORIS
        // ============================================
        echo "❤️ Création des favoris...\n";
        foreach ($clientIds as $clientId) {
            $nbFavoris = rand(2, 6);
            $favorisProduits = array_rand(array_flip($produitIds), $nbFavoris);
            if (!is_array($favorisProduits)) {
                $favorisProduits = [$favorisProduits];
            }
            foreach ($favorisProduits as $prodId) {
                DB::table('favoris')->insert([
                    'client_id' => $clientId,
                    'produit_id' => $prodId,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
            }
        }

        echo "\n✅ Seeding terminé avec succès !\n\n";

        echo "📊 Récapitulatif :\n";
        echo "   👑 1 Admin        : admin@madinlocal.com / password\n";
        echo "   👤 " . count($clientIds) . " Clients\n";
        echo "   🎨 " . count($artisanIds) . " Artisans\n";
        echo "   💼 " . count($investisseurUserIds) . " Investisseurs\n";
        echo "   📂 " . count($categoryIds) . " Catégories\n";
        echo "   🛍️ " . count($produitIds) . " Produits\n";
        echo "   🛒 25 Commandes\n";
        echo "\n🔐 Mot de passe pour tous : password\n\n";
    }

    /**
     * Commentaires aléatoires pour les évaluations
     */
    private function randomCommentaire(): string
    {
        $commentaires = [
            'Excellent travail ! La qualité est au rendez-vous.',
            'Très belle pièce, je suis ravi de mon achat.',
            'L\'artisan est très talentueux, je recommande vivement.',
            'Livraison rapide et produit conforme à la description.',
            'Magnifique création, encore plus beau en vrai !',
            'Très satisfait, je reviendrai acheter d\'autres produits.',
            'La finition est impeccable, on sent le travail artisanal.',
            'Superbe ! Mes invités ont adoré la pièce.',
            'Qualité exceptionnelle pour un prix très raisonnable.',
            'Artisan passionné, ça se voit dans chaque détail.',
            'Parfait ! Exactement ce que je cherchais.',
            'Très bon rapport qualité-prix, merci MadinLocal !',
        ];

        return $commentaires[array_rand($commentaires)];
    }
}