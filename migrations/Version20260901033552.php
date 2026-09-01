<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260901033552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite ADD COLUMN titre_pt_br VARCHAR(150) DEFAULT NULL');
        $this->addSql('ALTER TABLE actualite ADD COLUMN contenu_pt_br CLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE actualite ADD COLUMN image_pt_br VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE solution ADD COLUMN nom_pt_br VARCHAR(150) DEFAULT NULL');
        $this->addSql('ALTER TABLE solution ADD COLUMN description_pt_br VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE solution ADD COLUMN description_complete_pt_br CLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE solution ADD COLUMN image_pt_br VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE solution ADD COLUMN lien_apple_store VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__actualite AS SELECT id, titre, slug, contenu, titre_fr, titre_en, titre_de, contenu_fr, contenu_en, contenu_de, image, image_fr, image_en, image_de, date_publication, statut, created_at FROM actualite');
        $this->addSql('DROP TABLE actualite');
        $this->addSql('CREATE TABLE actualite (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(150) NOT NULL, slug VARCHAR(150) NOT NULL, contenu CLOB NOT NULL, titre_fr VARCHAR(150) DEFAULT NULL, titre_en VARCHAR(150) DEFAULT NULL, titre_de VARCHAR(150) DEFAULT NULL, contenu_fr CLOB DEFAULT NULL, contenu_en CLOB DEFAULT NULL, contenu_de CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, image_fr VARCHAR(255) DEFAULT NULL, image_en VARCHAR(255) DEFAULT NULL, image_de VARCHAR(255) DEFAULT NULL, date_publication DATETIME NOT NULL, statut VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO actualite (id, titre, slug, contenu, titre_fr, titre_en, titre_de, contenu_fr, contenu_en, contenu_de, image, image_fr, image_en, image_de, date_publication, statut, created_at) SELECT id, titre, slug, contenu, titre_fr, titre_en, titre_de, contenu_fr, contenu_en, contenu_de, image, image_fr, image_en, image_de, date_publication, statut, created_at FROM __temp__actualite');
        $this->addSql('DROP TABLE __temp__actualite');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_54928197989D9B62 ON actualite (slug)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__solution AS SELECT id, nom, slug, description, nom_fr, nom_en, nom_de, description_fr, description_en, description_de, description_complete, description_complete_fr, description_complete_en, description_complete_de, image, image_fr, image_en, image_de, icone, categorie, statut, lien_google_play, ordre_affichage, created_at FROM solution');
        $this->addSql('DROP TABLE solution');
        $this->addSql('CREATE TABLE solution (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, slug VARCHAR(150) NOT NULL, description VARCHAR(255) NOT NULL, nom_fr VARCHAR(150) DEFAULT NULL, nom_en VARCHAR(150) DEFAULT NULL, nom_de VARCHAR(150) DEFAULT NULL, description_fr VARCHAR(255) DEFAULT NULL, description_en VARCHAR(255) DEFAULT NULL, description_de VARCHAR(255) DEFAULT NULL, description_complete CLOB DEFAULT NULL, description_complete_fr CLOB DEFAULT NULL, description_complete_en CLOB DEFAULT NULL, description_complete_de CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, image_fr VARCHAR(255) DEFAULT NULL, image_en VARCHAR(255) DEFAULT NULL, image_de VARCHAR(255) DEFAULT NULL, icone VARCHAR(10) DEFAULT NULL, categorie VARCHAR(100) DEFAULT NULL, statut VARCHAR(20) NOT NULL, lien_google_play VARCHAR(255) DEFAULT NULL, ordre_affichage INTEGER NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO solution (id, nom, slug, description, nom_fr, nom_en, nom_de, description_fr, description_en, description_de, description_complete, description_complete_fr, description_complete_en, description_complete_de, image, image_fr, image_en, image_de, icone, categorie, statut, lien_google_play, ordre_affichage, created_at) SELECT id, nom, slug, description, nom_fr, nom_en, nom_de, description_fr, description_en, description_de, description_complete, description_complete_fr, description_complete_en, description_complete_de, image, image_fr, image_en, image_de, icone, categorie, statut, lien_google_play, ordre_affichage, created_at FROM __temp__solution');
        $this->addSql('DROP TABLE __temp__solution');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F3329DB989D9B62 ON solution (slug)');
    }
}
