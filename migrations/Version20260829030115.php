<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260829030115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(150) NOT NULL, slug VARCHAR(150) NOT NULL, contenu CLOB NOT NULL, titre_fr VARCHAR(150) DEFAULT NULL, titre_en VARCHAR(150) DEFAULT NULL, titre_de VARCHAR(150) DEFAULT NULL, contenu_fr CLOB DEFAULT NULL, contenu_en CLOB DEFAULT NULL, contenu_de CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, image_fr VARCHAR(255) DEFAULT NULL, image_en VARCHAR(255) DEFAULT NULL, image_de VARCHAR(255) DEFAULT NULL, date_publication DATETIME NOT NULL, statut VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_54928197989D9B62 ON actualite (slug)');
        $this->addSql('CREATE TABLE admin (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, roles CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76E7927C74 ON admin (email)');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, sujet VARCHAR(150) NOT NULL, message CLOB NOT NULL, created_at DATETIME NOT NULL, traite BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE solution (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, slug VARCHAR(150) NOT NULL, description VARCHAR(255) NOT NULL, nom_fr VARCHAR(150) DEFAULT NULL, nom_en VARCHAR(150) DEFAULT NULL, nom_de VARCHAR(150) DEFAULT NULL, description_fr VARCHAR(255) DEFAULT NULL, description_en VARCHAR(255) DEFAULT NULL, description_de VARCHAR(255) DEFAULT NULL, description_complete CLOB DEFAULT NULL, description_complete_fr CLOB DEFAULT NULL, description_complete_en CLOB DEFAULT NULL, description_complete_de CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, image_fr VARCHAR(255) DEFAULT NULL, image_en VARCHAR(255) DEFAULT NULL, image_de VARCHAR(255) DEFAULT NULL, icone VARCHAR(10) DEFAULT NULL, categorie VARCHAR(100) DEFAULT NULL, statut VARCHAR(20) NOT NULL, lien_google_play VARCHAR(255) DEFAULT NULL, ordre_affichage INTEGER NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F3329DB989D9B62 ON solution (slug)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE solution');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
