<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250801194309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user_profile DROP CONSTRAINT fk_d95ab4059d86650f
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX uniq_d95ab4059d86650f
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_profile RENAME COLUMN user_id_id TO user_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB405A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_D95AB405A76ED395 ON user_profile (user_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user_profile DROP CONSTRAINT FK_D95AB405A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_D95AB405A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_profile RENAME COLUMN user_id TO user_id_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_profile ADD CONSTRAINT fk_d95ab4059d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_d95ab4059d86650f ON user_profile (user_id_id)
        SQL);
    }
}
