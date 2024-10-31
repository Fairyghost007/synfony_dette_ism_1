<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241031000721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP CONSTRAINT fk_c744045567b3b43d');
        $this->addSql('DROP INDEX uniq_c744045567b3b43d');
        $this->addSql('ALTER TABLE client ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client DROP users_id');
        $this->addSql('ALTER TABLE users ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE users ALTER login TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE users ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E919EB6921 ON users (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN ON users (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE client ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client DROP email');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_c744045567b3b43d FOREIGN KEY (users_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_c744045567b3b43d ON client (users_id)');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E919EB6921');
        $this->addSql('DROP INDEX UNIQ_1483A5E919EB6921');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_LOGIN');
        $this->addSql('ALTER TABLE users DROP client_id');
        $this->addSql('ALTER TABLE users DROP roles');
        $this->addSql('ALTER TABLE users ALTER login TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE users ALTER password TYPE VARCHAR(50)');
    }
}
