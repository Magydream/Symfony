<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220607125311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE admin4 ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('INSERT INTO admin4 (username, roles, password , first_name , last_name) VALUES (\'admin\', \'["ROLE_ADMIN"]\',
\'$2y$13$YJ9Nway6fX/6rQGC//IVD.Gkg3fIin/kz1ewECPe0voHC0l1g7F/O\', \'Yoann2\', \'Labrue2\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin4 DROP first_name, DROP last_name');
    }
}
