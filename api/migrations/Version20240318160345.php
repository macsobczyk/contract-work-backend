<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318160345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, post_code VARCHAR(10) DEFAULT NULL, city VARCHAR(50) NOT NULL, country_code VARCHAR(2) NOT NULL, phone_number VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE bank_account (id INT NOT NULL, account_owner_id INT NOT NULL, name VARCHAR(255) NOT NULL, swift VARCHAR(12) NOT NULL, account_number VARCHAR(255) NOT NULL, bank_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_53A23E0A6F2834F ON bank_account (account_owner_id)');
        $this->addSql('CREATE TABLE company (id INT NOT NULL, address_id INT NOT NULL, name VARCHAR(255) NOT NULL, shortname VARCHAR(50) NOT NULL, vatin VARCHAR(50) NOT NULL, court_registry VARCHAR(255) NOT NULL, registry_number VARCHAR(30) NOT NULL, initial_capital VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FF5B7AF75 ON company (address_id)');
        $this->addSql('CREATE TABLE company_representation (id INT NOT NULL, company_user_id INT NOT NULL, company_id INT NOT NULL, position VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_71D663D873CC942 ON company_representation (company_user_id)');
        $this->addSql('CREATE INDEX IDX_71D663D979B1AD6 ON company_representation (company_id)');
        $this->addSql('CREATE TABLE contract (id INT NOT NULL, company_id INT NOT NULL, representation_id INT NOT NULL, contractor_id INT NOT NULL, contractor_bank_account_id INT NOT NULL, contract_template_id INT NOT NULL, contract_number VARCHAR(255) NOT NULL, issued_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, terminated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, paid_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, contract_value_net INT NOT NULL, contract_value_gross INT NOT NULL, contract_value_tax INT NOT NULL, subject VARCHAR(255) NOT NULL, results TEXT DEFAULT NULL, is_paid BOOLEAN NOT NULL, is_tax_paid BOOLEAN NOT NULL, is_undersigned BOOLEAN NOT NULL, is_booked BOOLEAN NOT NULL, is_result_delivered BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E98F2859979B1AD6 ON contract (company_id)');
        $this->addSql('CREATE INDEX IDX_E98F285946CE82F4 ON contract (representation_id)');
        $this->addSql('CREATE INDEX IDX_E98F2859B0265DC7 ON contract (contractor_id)');
        $this->addSql('CREATE INDEX IDX_E98F285949CEA97C ON contract (contractor_bank_account_id)');
        $this->addSql('CREATE INDEX IDX_E98F28594771D675 ON contract (contract_template_id)');
        $this->addSql('CREATE TABLE contract_attachment (id INT NOT NULL, contract_id INT NOT NULL, description VARCHAR(255) NOT NULL, file_path VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_601E78922576E0FD ON contract_attachment (contract_id)');
        $this->addSql('CREATE TABLE contract_meta (id INT NOT NULL, contract_id INT NOT NULL, field_name VARCHAR(255) NOT NULL, field_value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BF875A5D2576E0FD ON contract_meta (contract_id)');
        $this->addSql('CREATE TABLE contract_result (id INT NOT NULL, contract_id INT NOT NULL, description VARCHAR(255) NOT NULL, file_path VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2F2A245E2576E0FD ON contract_result (contract_id)');
        $this->addSql('CREATE TABLE contract_template (id INT NOT NULL, name VARCHAR(255) NOT NULL, language_code VARCHAR(2) NOT NULL, contract_template_path VARCHAR(255) NOT NULL, bill_template_path VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, address_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, middlename VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) NOT NULL, username VARCHAR(50) NOT NULL, email_address VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles jsonb NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, pesel VARCHAR(50) DEFAULT NULL, vatin VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649B08E074E ON "user" (email_address)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F5B7AF75 ON "user" (address_id)');
        $this->addSql('COMMENT ON COLUMN "user".expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE bank_account ADD CONSTRAINT FK_53A23E0A6F2834F FOREIGN KEY (account_owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_representation ADD CONSTRAINT FK_71D663D873CC942 FOREIGN KEY (company_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_representation ADD CONSTRAINT FK_71D663D979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285946CE82F4 FOREIGN KEY (representation_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859B0265DC7 FOREIGN KEY (contractor_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285949CEA97C FOREIGN KEY (contractor_bank_account_id) REFERENCES bank_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F28594771D675 FOREIGN KEY (contract_template_id) REFERENCES contract_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract_attachment ADD CONSTRAINT FK_601E78922576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract_meta ADD CONSTRAINT FK_BF875A5D2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract_result ADD CONSTRAINT FK_2F2A245E2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE bank_account DROP CONSTRAINT FK_53A23E0A6F2834F');
        $this->addSql('ALTER TABLE company DROP CONSTRAINT FK_4FBF094FF5B7AF75');
        $this->addSql('ALTER TABLE company_representation DROP CONSTRAINT FK_71D663D873CC942');
        $this->addSql('ALTER TABLE company_representation DROP CONSTRAINT FK_71D663D979B1AD6');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F2859979B1AD6');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F285946CE82F4');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F2859B0265DC7');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F285949CEA97C');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F28594771D675');
        $this->addSql('ALTER TABLE contract_attachment DROP CONSTRAINT FK_601E78922576E0FD');
        $this->addSql('ALTER TABLE contract_meta DROP CONSTRAINT FK_BF875A5D2576E0FD');
        $this->addSql('ALTER TABLE contract_result DROP CONSTRAINT FK_2F2A245E2576E0FD');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649F5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE bank_account');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_representation');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE contract_attachment');
        $this->addSql('DROP TABLE contract_meta');
        $this->addSql('DROP TABLE contract_result');
        $this->addSql('DROP TABLE contract_template');
        $this->addSql('DROP TABLE "user"');
    }
}
