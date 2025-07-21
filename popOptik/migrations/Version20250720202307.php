<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250720202307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE appointment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE brand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cart_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contact_lens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE gender_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE gift_card_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE glass_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mailing_offer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_info_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE appointment (id INT NOT NULL, user_appointment_id INT NOT NULL, user_rdv_id INT DEFAULT NULL, appointment_date DATE DEFAULT NULL, appointment_hour TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FE38F8448E30ECA0 ON appointment (user_appointment_id)');
        $this->addSql('CREATE INDEX IDX_FE38F844299C24BB ON appointment (user_rdv_id)');
        $this->addSql('CREATE TABLE brand (id INT NOT NULL, name VARCHAR(80) NOT NULL, contact_lens VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cart (id INT NOT NULL, usercart_id INT DEFAULT NULL, item_id INT DEFAULT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BA388B786B43101 ON cart (usercart_id)');
        $this->addSql('CREATE INDEX IDX_BA388B7126F525E ON cart (item_id)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(80) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE contact_lens (id INT NOT NULL, power_contact_lens_left INT NOT NULL, power_contact_lens_right INT NOT NULL, quantity INT DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE contact_lens_user (contact_lens_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(contact_lens_id, user_id))');
        $this->addSql('CREATE INDEX IDX_EA0FF222D5E49CFB ON contact_lens_user (contact_lens_id)');
        $this->addSql('CREATE INDEX IDX_EA0FF222A76ED395 ON contact_lens_user (user_id)');
        $this->addSql('CREATE TABLE gender (id INT NOT NULL, gender VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE gift_card (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE gift_card_user (gift_card_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(gift_card_id, user_id))');
        $this->addSql('CREATE INDEX IDX_F7EF79812696A98F ON gift_card_user (gift_card_id)');
        $this->addSql('CREATE INDEX IDX_F7EF7981A76ED395 ON gift_card_user (user_id)');
        $this->addSql('CREATE TABLE glass (id INT NOT NULL, item_id INT DEFAULT NULL, category_id INT DEFAULT NULL, gender_id INT DEFAULT NULL, brand_id INT DEFAULT NULL, color VARCHAR(50) NOT NULL, shape VARCHAR(50) NOT NULL, matter VARCHAR(50) NOT NULL, image_path VARCHAR(300) DEFAULT NULL, image_name VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_18CBBF5F126F525E ON glass (item_id)');
        $this->addSql('CREATE INDEX IDX_18CBBF5F12469DE2 ON glass (category_id)');
        $this->addSql('CREATE INDEX IDX_18CBBF5F708A0E0 ON glass (gender_id)');
        $this->addSql('CREATE INDEX IDX_18CBBF5F44F5D008 ON glass (brand_id)');
        $this->addSql('CREATE TABLE item (id INT NOT NULL, glass_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, price NUMERIC(10, 2) NOT NULL, stock INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251E6E4A05EA ON item (glass_id)');
        $this->addSql('CREATE TABLE item_user (item_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(item_id, user_id))');
        $this->addSql('CREATE INDEX IDX_45A392B2126F525E ON item_user (item_id)');
        $this->addSql('CREATE INDEX IDX_45A392B2A76ED395 ON item_user (user_id)');
        $this->addSql('CREATE TABLE item_order (item_id INT NOT NULL, order_id INT NOT NULL, PRIMARY KEY(item_id, order_id))');
        $this->addSql('CREATE INDEX IDX_DF8E8848126F525E ON item_order (item_id)');
        $this->addSql('CREATE INDEX IDX_DF8E88488D9F6D38 ON item_order (order_id)');
        $this->addSql('CREATE TABLE mailing_offer (id INT NOT NULL, rappel_achat_lunette DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE mailing_offer_user (mailing_offer_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(mailing_offer_id, user_id))');
        $this->addSql('CREATE INDEX IDX_953AA12F8EDAD8C2 ON mailing_offer_user (mailing_offer_id)');
        $this->addSql('CREATE INDEX IDX_953AA12FA76ED395 ON mailing_offer_user (user_id)');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, user_info_id INT DEFAULT NULL, user_infos_order_id INT DEFAULT NULL, order_number VARCHAR(200) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F5299398586DFF2 ON "order" (user_info_id)');
        $this->addSql('CREATE INDEX IDX_F529939830CBA962 ON "order" (user_infos_order_id)');
        $this->addSql('CREATE TABLE order_item (order_id INT NOT NULL, item_id INT NOT NULL, PRIMARY KEY(order_id, item_id))');
        $this->addSql('CREATE INDEX IDX_52EA1F098D9F6D38 ON order_item (order_id)');
        $this->addSql('CREATE INDEX IDX_52EA1F09126F525E ON order_item (item_id)');
        $this->addSql('CREATE TABLE role (id INT NOT NULL, name VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, id_user_infos INT NOT NULL, role_id INT NOT NULL, day_of_birth SMALLINT NOT NULL, month_of_birth VARCHAR(50) NOT NULL, year_of_birth SMALLINT NOT NULL, password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A982F9E2 ON "user" (id_user_infos)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON "user" (role_id)');
        $this->addSql('CREATE TABLE user_info (id INT NOT NULL, email VARCHAR(180) NOT NULL, phone VARCHAR(20) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, address VARCHAR(150) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1087D9EE7927C74 ON user_info (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8448E30ECA0 FOREIGN KEY (user_appointment_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844299C24BB FOREIGN KEY (user_rdv_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B786B43101 FOREIGN KEY (usercart_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact_lens_user ADD CONSTRAINT FK_EA0FF222D5E49CFB FOREIGN KEY (contact_lens_id) REFERENCES contact_lens (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact_lens_user ADD CONSTRAINT FK_EA0FF222A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gift_card_user ADD CONSTRAINT FK_F7EF79812696A98F FOREIGN KEY (gift_card_id) REFERENCES gift_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gift_card_user ADD CONSTRAINT FK_F7EF7981A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE glass ADD CONSTRAINT FK_18CBBF5F126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE glass ADD CONSTRAINT FK_18CBBF5F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE glass ADD CONSTRAINT FK_18CBBF5F708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE glass ADD CONSTRAINT FK_18CBBF5F44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E6E4A05EA FOREIGN KEY (glass_id) REFERENCES glass (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_user ADD CONSTRAINT FK_45A392B2126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_user ADD CONSTRAINT FK_45A392B2A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_order ADD CONSTRAINT FK_DF8E8848126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_order ADD CONSTRAINT FK_DF8E88488D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mailing_offer_user ADD CONSTRAINT FK_953AA12F8EDAD8C2 FOREIGN KEY (mailing_offer_id) REFERENCES mailing_offer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mailing_offer_user ADD CONSTRAINT FK_953AA12FA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398586DFF2 FOREIGN KEY (user_info_id) REFERENCES user_info (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F529939830CBA962 FOREIGN KEY (user_infos_order_id) REFERENCES user_info (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649A982F9E2 FOREIGN KEY (id_user_infos) REFERENCES user_info (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE appointment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE brand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cart_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contact_lens_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE gender_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE gift_card_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE glass_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mailing_offer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE role_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_info_id_seq CASCADE');
        $this->addSql('ALTER TABLE appointment DROP CONSTRAINT FK_FE38F8448E30ECA0');
        $this->addSql('ALTER TABLE appointment DROP CONSTRAINT FK_FE38F844299C24BB');
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT FK_BA388B786B43101');
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT FK_BA388B7126F525E');
        $this->addSql('ALTER TABLE contact_lens_user DROP CONSTRAINT FK_EA0FF222D5E49CFB');
        $this->addSql('ALTER TABLE contact_lens_user DROP CONSTRAINT FK_EA0FF222A76ED395');
        $this->addSql('ALTER TABLE gift_card_user DROP CONSTRAINT FK_F7EF79812696A98F');
        $this->addSql('ALTER TABLE gift_card_user DROP CONSTRAINT FK_F7EF7981A76ED395');
        $this->addSql('ALTER TABLE glass DROP CONSTRAINT FK_18CBBF5F126F525E');
        $this->addSql('ALTER TABLE glass DROP CONSTRAINT FK_18CBBF5F12469DE2');
        $this->addSql('ALTER TABLE glass DROP CONSTRAINT FK_18CBBF5F708A0E0');
        $this->addSql('ALTER TABLE glass DROP CONSTRAINT FK_18CBBF5F44F5D008');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251E6E4A05EA');
        $this->addSql('ALTER TABLE item_user DROP CONSTRAINT FK_45A392B2126F525E');
        $this->addSql('ALTER TABLE item_user DROP CONSTRAINT FK_45A392B2A76ED395');
        $this->addSql('ALTER TABLE item_order DROP CONSTRAINT FK_DF8E8848126F525E');
        $this->addSql('ALTER TABLE item_order DROP CONSTRAINT FK_DF8E88488D9F6D38');
        $this->addSql('ALTER TABLE mailing_offer_user DROP CONSTRAINT FK_953AA12F8EDAD8C2');
        $this->addSql('ALTER TABLE mailing_offer_user DROP CONSTRAINT FK_953AA12FA76ED395');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398586DFF2');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F529939830CBA962');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F098D9F6D38');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F09126F525E');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649A982F9E2');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649D60322AC');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE contact_lens');
        $this->addSql('DROP TABLE contact_lens_user');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP TABLE gift_card');
        $this->addSql('DROP TABLE gift_card_user');
        $this->addSql('DROP TABLE glass');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_user');
        $this->addSql('DROP TABLE item_order');
        $this->addSql('DROP TABLE mailing_offer');
        $this->addSql('DROP TABLE mailing_offer_user');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_info');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
