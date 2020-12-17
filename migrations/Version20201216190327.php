<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216190327 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_category ADD menu_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu_category ADD CONSTRAINT FK_2A1D5C57CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_category ADD CONSTRAINT FK_2A1D5C5712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2A1D5C57CCD7E912 ON menu_category (menu_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2A1D5C5712469DE2 ON menu_category (category_id)');
        $this->addSql('ALTER TABLE next_category DROP FOREIGN KEY FK_3E56552F796A8F92');
        $this->addSql('ALTER TABLE next_category DROP FOREIGN KEY FK_3E56552FC8C2FACC');
        $this->addSql('DROP INDEX IDX_3E56552FC8C2FACC ON next_category');
        $this->addSql('DROP INDEX IDX_3E56552F796A8F92 ON next_category');
        $this->addSql('ALTER TABLE next_category DROP parent_category_id, DROP child_category_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_category DROP FOREIGN KEY FK_2A1D5C57CCD7E912');
        $this->addSql('ALTER TABLE menu_category DROP FOREIGN KEY FK_2A1D5C5712469DE2');
        $this->addSql('DROP INDEX UNIQ_2A1D5C57CCD7E912 ON menu_category');
        $this->addSql('DROP INDEX UNIQ_2A1D5C5712469DE2 ON menu_category');
        $this->addSql('ALTER TABLE menu_category DROP menu_id, DROP category_id');
        $this->addSql('ALTER TABLE next_category ADD parent_category_id INT DEFAULT NULL, ADD child_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE next_category ADD CONSTRAINT FK_3E56552F796A8F92 FOREIGN KEY (parent_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE next_category ADD CONSTRAINT FK_3E56552FC8C2FACC FOREIGN KEY (child_category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_3E56552FC8C2FACC ON next_category (child_category_id)');
        $this->addSql('CREATE INDEX IDX_3E56552F796A8F92 ON next_category (parent_category_id)');
    }
}
