<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141009143709 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE order__order CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE order__order_audit CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE invoice__invoice CHANGE currency currency CHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE invoice__invoice_audit CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE basket__basket CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE fitbase_weeklyquiz DROP FOREIGN KEY FK_2D32AB9379BF1BCE');
        $this->addSql('DROP INDEX IDX_2D32AB9379BF1BCE ON fitbase_weeklyquiz');
        $this->addSql('ALTER TABLE fitbase_weeklyquiz DROP answers_id');
        $this->addSql('ALTER TABLE fitbase_weeklyquiz_audit DROP answers_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE basket__basket CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE fitbase_weeklyquiz ADD answers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fitbase_weeklyquiz ADD CONSTRAINT FK_2D32AB9379BF1BCE FOREIGN KEY (answers_id) REFERENCES fitbase_weeklyquiz_answer (id)');
        $this->addSql('CREATE INDEX IDX_2D32AB9379BF1BCE ON fitbase_weeklyquiz (answers_id)');
        $this->addSql('ALTER TABLE fitbase_weeklyquiz_audit ADD answers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE invoice__invoice CHANGE currency currency CHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE invoice__invoice_audit CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE order__order CHANGE currency currency CHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE order__order_audit CHANGE currency currency CHAR(3) DEFAULT NULL');
    }
}
