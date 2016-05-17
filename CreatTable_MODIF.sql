-- -----------------------------------------------------------------------------
--             GEnEration d'une base de donnees pour
--                      Oracle Version 9i
--                        (7/4/2016 17:16:54)
-- -----------------------------------------------------------------------------
--      Nom de la base : modele_physique_Drive
--      Projet : Drive
--      Auteur : Malika
--      Date de dernière modification : 7/4/2016 17:07:19
-- -----------------------------------------------------------------------------
--
--
--      J'ai rajouter des DELETE ON CASCADE afin de laisser oracle gerer les suppresion
--      J'ai changer toute les variable "CHAR" en VARCHAR2, car c'était la cause
--      des espace blanc qui remplissait l'attribut "nom           "(char32)
--      plus besoin de faire de "LIKE %" 
--      
--
DROP TABLE CATEGORIE CASCADE CONSTRAINTS;

DROP TABLE SOUS_SOUS_RAYON CASCADE CONSTRAINTS;

DROP TABLE SOUS_RAYON CASCADE CONSTRAINTS;

DROP TABLE PROMOTION CASCADE CONSTRAINTS;

DROP TABLE P_LOT CASCADE CONSTRAINTS;

DROP TABLE PANIER CASCADE CONSTRAINTS;

DROP TABLE CLIENT CASCADE CONSTRAINTS;

DROP TABLE PRODUIT CASCADE CONSTRAINTS;

DROP TABLE RAYON CASCADE CONSTRAINTS;

DROP TABLE P_INDIVIDUELLE CASCADE CONSTRAINTS;

DROP TABLE PLANNING CASCADE CONSTRAINTS;

DROP TABLE SSR_P CASCADE CONSTRAINTS;

DROP TABLE SR_P CASCADE CONSTRAINTS;

DROP TABLE OBJET_PROMO CASCADE CONSTRAINTS;

DROP TABLE ITEM CASCADE CONSTRAINTS;



-- -----------------------------------------------------------------------------
--       TABLE : CATEGORIE
-- -----------------------------------------------------------------------------

CREATE TABLE CATEGORIE
   (
    NOM_CATEGORIE VARCHAR2(32)  NOT NULL
,   CONSTRAINT PK_CATEGORIE PRIMARY KEY (NOM_CATEGORIE)  
   ) ;


-- -----------------------------------------------------------------------------
--       TABLE : RAYON
-- -----------------------------------------------------------------------------

CREATE TABLE RAYON
   (
    NOM_RAYON VARCHAR2(32)  NOT NULL,
    NOM_CATEGORIE VARCHAR2(32)  NOT NULL
,   CONSTRAINT PK_RAYON PRIMARY KEY (NOM_RAYON)  
   ) ;


-- -----------------------------------------------------------------------------
--       TABLE : SOUS_RAYON
-- -----------------------------------------------------------------------------

CREATE TABLE SOUS_RAYON
   (
    NOM_SR VARCHAR2(32)  NOT NULL,
    NOM_RAYON VARCHAR2(32)  NOT NULL
,   CONSTRAINT PK_SOUS_RAYON PRIMARY KEY (NOM_SR)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : SOUS_SOUS_RAYON
-- -----------------------------------------------------------------------------

CREATE TABLE SOUS_SOUS_RAYON
   (
    NOM_SSR VARCHAR2(128)  NOT NULL,
    NOM_SR VARCHAR2(32)  NOT NULL
,   CONSTRAINT PK_SOUS_SOUS_RAYON PRIMARY KEY (NOM_SSR)  
   ) ;


-- -----------------------------------------------------------------------------
--       TABLE : SSR_P
-- -----------------------------------------------------------------------------

CREATE TABLE SSR_P
   (
    REFERENCE VARCHAR2(32)  NOT NULL,
    NOM_SSR VARCHAR2(128)  NOT NULL
,   CONSTRAINT PK_SSR_P PRIMARY KEY (REFERENCE, NOM_SSR)  
   ) ;


-- -----------------------------------------------------------------------------
--       TABLE : SR_P
-- -----------------------------------------------------------------------------

CREATE TABLE SR_P
   (
    REFERENCE VARCHAR2(32)  NOT NULL,
    NOM_SR VARCHAR2(32)  NOT NULL
,   CONSTRAINT PK_SR_P PRIMARY KEY (REFERENCE, NOM_SR)  
   ) ;


-- -----------------------------------------------------------------------------
--       TABLE : PROMOTION
-- -----------------------------------------------------------------------------

CREATE TABLE PROMOTION
   (
    CODE_PROMO VARCHAR2(128)  NOT NULL,
    DATE_DEBUT DATE  NOT NULL,
    DATE_FIN DATE  NOT NULL,
    MAX_PAR_CLIENT NUMBER(1)  NOT NULL
,   CONSTRAINT PK_PROMOTION PRIMARY KEY (CODE_PROMO)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : P_LOT
-- -----------------------------------------------------------------------------

CREATE TABLE P_LOT
   (
    CODE_PROMO VARCHAR2(128)  NOT NULL,
    NB_ACHETES NUMBER(1)  NOT NULL,
    NB_GRATUITS NUMBER(1)  NOT NULL
,   CONSTRAINT PK_P_LOT PRIMARY KEY (CODE_PROMO)  
   ) ;


-- -----------------------------------------------------------------------------
--       TABLE : P_INDIVIDUELLE
-- -----------------------------------------------------------------------------

CREATE TABLE P_INDIVIDUELLE
   (
    CODE_PROMO VARCHAR2(128)  NOT NULL,
    REDUCTION_ABSOLUE NUMBER(4,2)  NULL,
    REDUCTION_RELATIVE NUMBER(4,2)  NULL,
    IMMEDIATE_VF VARCHAR2(32)  NULL
,   CONSTRAINT PK_P_INDIVIDUELLE PRIMARY KEY (CODE_PROMO)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : CLIENT
-- -----------------------------------------------------------------------------

CREATE TABLE CLIENT
   (
    NO_CARTE NUMBER(10)  NOT NULL,
    CREDIT_CARTE NUMBER(13,2) 
      DEFAULT 0 NOT NULL,
    NOM VARCHAR2(128)  NULL,
    PRENOM VARCHAR2(128)  NOT NULL,
    ADRESSE VARCHAR2(128)  NOT NULL,
    E_MAIL VARCHAR2(128)  NOT NULL,
    TELEPHONE VARCHAR2(32)  NOT NULL
,   CONSTRAINT PK_CLIENT PRIMARY KEY (NO_CARTE)  
   ) ;



-- -----------------------------------------------------------------------------
--       TABLE : PANIER
-- -----------------------------------------------------------------------------

CREATE TABLE PANIER
   (
    NO_CARTE NUMBER(10)  NOT NULL,
    DATE_HEURE DATE  NULL,
    VIDE_VF VARCHAR2(1) 
      DEFAULT 'V' NOT NULL CHECK (VIDE_VF IN ('V','F')),
    DATEVALIDATION DATE  NULL,
    MONTANT NUMBER(13,2)  NULL,
    CONSTRAINT PK_PANIER PRIMARY KEY (NO_CARTE)  
   ) ;


-- -----------------------------------------------------------------------------
--       TABLE : PRODUIT
-- -----------------------------------------------------------------------------

CREATE TABLE PRODUIT
   (
    REFERENCE VARCHAR2(32)  NOT NULL,
    LIBELLE VARCHAR2(128)  NOT NULL,
    MARQUE VARCHAR2(128)  NOT NULL,
    FICHIER_IMAGE VARCHAR2(128)  NULL,
    PRIX_UNIT_HT NUMBER(13,2)  NOT NULL,
    LIQUIDE_VF VARCHAR2(1)  NOT NULL CHECK (LIQUIDE_VF IN ('V','F')),
    PRIX_KILO_OU_LITRE NUMBER(13,2)  NOT NULL,
    QUANTITE_STOCK NUMBER(10)  NOT NULL CHECK (QUANTITE_STOCK >=0),
    CONSTRAINT PK_PRODUIT PRIMARY KEY (REFERENCE)  
   ) ;






-- -----------------------------------------------------------------------------
--       TABLE : PLANNING
-- -----------------------------------------------------------------------------

CREATE TABLE PLANNING
   (
    DATE_HEURE DATE  NOT NULL,
    NOMBRE_LIVRAISONS_MAX NUMBER(1)  NOT NULL
,   CONSTRAINT PK_PLANNING PRIMARY KEY (DATE_HEURE)  
   ) ;




-- -----------------------------------------------------------------------------
--       TABLE : OBJET_PROMO
-- -----------------------------------------------------------------------------

CREATE TABLE OBJET_PROMO
   (
    CODE_PROMO VARCHAR2(128)  NOT NULL,
    REFERENCE VARCHAR2(32)  NOT NULL
,   CONSTRAINT PK_OBJET_PROMO PRIMARY KEY (CODE_PROMO, REFERENCE)  
   ) ;



-- -----------------------------------------------------------------------------
--       TABLE : ITEM
-- -----------------------------------------------------------------------------

CREATE TABLE ITEM
   (
    NO_CARTE NUMBER(10)  NOT NULL,
    REFERENCE VARCHAR2(32)  NOT NULL,
    QUANTITE NUMBER(3) 
      DEFAULT 1 NOT NULL CHECK (QUANTITE >=1)
,   CONSTRAINT PK_ITEM PRIMARY KEY (NO_CARTE, REFERENCE)  
   ) ;


-- -----------------------------------------------------------------------------
--       CREATION DES REFERENCES DE TABLE (CLES ETRANGERES)
-- -----------------------------------------------------------------------------


ALTER TABLE SOUS_SOUS_RAYON ADD (
     CONSTRAINT FK_SOUS_SOUS_RAYON_SOUS_RAYON
          FOREIGN KEY (NOM_SR)
               REFERENCES SOUS_RAYON (NOM_SR)  ON DELETE CASCADE)
;

ALTER TABLE SOUS_RAYON ADD (
     CONSTRAINT FK_SOUS_RAYON_RAYON
          FOREIGN KEY (NOM_RAYON)
               REFERENCES RAYON (NOM_RAYON)  ON DELETE CASCADE)   ;

ALTER TABLE P_LOT ADD (
     CONSTRAINT FK_P_LOT_PROMOTION
          FOREIGN KEY (CODE_PROMO)
               REFERENCES PROMOTION (CODE_PROMO)  ON DELETE CASCADE )   ;

ALTER TABLE PANIER ADD (
     CONSTRAINT FK_PANIER_CLIENT
          FOREIGN KEY (NO_CARTE)
               REFERENCES CLIENT (NO_CARTE)  ON DELETE CASCADE)   ;

ALTER TABLE PANIER ADD (
     CONSTRAINT FK_PANIER_PLANNING
          FOREIGN KEY (DATE_HEURE)
               REFERENCES PLANNING (DATE_HEURE) ON DELETE SET NULL)   ;

ALTER TABLE RAYON ADD (
     CONSTRAINT FK_RAYON_CATEGORIE
          FOREIGN KEY (NOM_CATEGORIE)
               REFERENCES CATEGORIE (NOM_CATEGORIE)  ON DELETE CASCADE)   ;

ALTER TABLE P_INDIVIDUELLE ADD (
     CONSTRAINT FK_P_INDIVIDUELLE_PROMOTION
          FOREIGN KEY (CODE_PROMO)
               REFERENCES PROMOTION (CODE_PROMO)  ON DELETE CASCADE)   ;

ALTER TABLE SSR_P ADD (
     CONSTRAINT FK_SSR_P_PRODUIT
          FOREIGN KEY (REFERENCE)
               REFERENCES PRODUIT (REFERENCE)  ON DELETE CASCADE)   ;

ALTER TABLE SSR_P ADD (
     CONSTRAINT FK_SSR_P_SOUS_SOUS_RAYON
          FOREIGN KEY (NOM_SSR)
               REFERENCES SOUS_SOUS_RAYON (NOM_SSR)  ON DELETE CASCADE)   ;

ALTER TABLE SR_P ADD (
     CONSTRAINT FK_SR_P_PRODUIT
          FOREIGN KEY (REFERENCE)
               REFERENCES PRODUIT (REFERENCE)  ON DELETE CASCADE)   ;

ALTER TABLE SR_P ADD (
     CONSTRAINT FK_SR_P_SOUS_RAYON
          FOREIGN KEY (NOM_SR)
               REFERENCES SOUS_RAYON (NOM_SR)  ON DELETE CASCADE)   ;

ALTER TABLE OBJET_PROMO ADD (
     CONSTRAINT FK_OBJET_PROMO_PROMOTION
          FOREIGN KEY (CODE_PROMO)
               REFERENCES PROMOTION (CODE_PROMO)  ON DELETE CASCADE)   ;

ALTER TABLE OBJET_PROMO ADD (
     CONSTRAINT FK_OBJET_PROMO_PRODUIT
          FOREIGN KEY (REFERENCE)
               REFERENCES PRODUIT (REFERENCE)  ON DELETE CASCADE)   ;

ALTER TABLE ITEM ADD (
     CONSTRAINT FK_ITEM_PANIER
          FOREIGN KEY (NO_CARTE)
               REFERENCES PANIER (NO_CARTE)  ON DELETE CASCADE)   ;

ALTER TABLE ITEM ADD (
     CONSTRAINT FK_ITEM_PRODUIT
          FOREIGN KEY (REFERENCE)
               REFERENCES PRODUIT (REFERENCE)  ON DELETE CASCADE)   ;


//Notre vue
CREATE OR REPLACE VIEW V_PRODUIT_RAY (REFERENCE, NOM_RAYON, NOM_SR )
 AS
(SELECT DISTINCT REFERENCE, NOM_RAYON, NOM_SR
FROM SR_P JOIN SOUS_RAYON USING (NOM_SR) JOIN RAYON USING(NOM_RAYON))
UNION
(SELECT distinct REFERENCE, NOM_RAYON, NOM_SR
 FROM SSR_P JOIN SOUS_SOUS_RAYON USING (NOM_SSR) JOIN SOUS_RAYON USING (NOM_SR) JOIN RAYON USING(NOM_RAYON));
-- -----------------------------------------------------------------------------
--                FIN DE GENERATION
-- -----------------------------------------------------------------------------

--
-- Database: "ProjetBDDL2"
--

--
-- Dumping data for table "CATEGORIE"
--

INSERT INTO "CATEGORIE" VALUES('Boissons');
INSERT INTO "CATEGORIE" VALUES('Fruits et Legumes');
INSERT INTO "CATEGORIE" VALUES('Poissons');
INSERT INTO "CATEGORIE" VALUES('Viandes');

--
-- Dumping data for table "CLIENT"
--

INSERT INTO "CLIENT" VALUES(1117144480, 3.00, 'Havoc', 'Mehdi', '258 Rue Sellier, Laxou', 'Havoc.Mehdi@univ-lorraine.fr', '0269833233');
INSERT INTO "CLIENT" VALUES(1223129340, 3.00, 'Barksdale', 'Irina', '259 Rue Charles3, Vandoeuvre', 'Barksdale.Irina@univ-lorraine.fr', '0219727247');
INSERT INTO "CLIENT" VALUES(1318935820, 6.00, 'Cobain', 'Yann', '96 Avenue saint-epvre, Metz', 'Cobain.Yann@univ-lorraine.fr', '0251771993');
INSERT INTO "CLIENT" VALUES(1434419360, 8.00, 'DuLac', 'Yann', '156 Place Lobau, Metz', 'DuLac.Yann@univ-lorraine.fr', '0255538892');
INSERT INTO "CLIENT" VALUES(1534358150, 9.00, 'Tarantino', 'Adrien', '104 Boulevard Charles3, Metz', 'Tarantino.Adrien@univ-lorraine.fr', '0222158371');
INSERT INTO "CLIENT" VALUES(1544619710, 3.00, 'Ionesco', 'Isabelle', '226 Avenue saint-epvre, Nancy', 'Ionesco.Isabelle@univ-lorraine.fr', '0289927862');
INSERT INTO "CLIENT" VALUES(2189959140, 4.00, 'Taha', 'Ali', '291 Avenue Charles3, Nancy', 'Taha.Ali@univ-lorraine.fr', '0269782461');
INSERT INTO "CLIENT" VALUES(2427538880, 8.00, 'Adeba', 'Perceval', '103 Place Charles3, Nancy', 'Adeba.Perceval@univ-lorraine.fr', '0299392368');
INSERT INTO "CLIENT" VALUES(2483463290, 2.00, 'Havoc', 'Mehdi', '165 Place Lobau, Metz', 'Havoc.Mehdi@univ-lorraine.fr', '0294227516');
INSERT INTO "CLIENT" VALUES(2876413650, 9.00, 'Kubrick', 'Perceval', '76 Place Stanislas, Nancy', 'Kubrick.Perceval@univ-lorraine.fr', '0225795229');
INSERT INTO "CLIENT" VALUES(3161756750, 4.00, 'Adeba', 'Jimmy', '170 Rue Charles3, Laxou', 'Adeba.Jimmy@univ-lorraine.fr', '0277925125');
INSERT INTO "CLIENT" VALUES(3372385960, 10.00, 'Tarantino', 'Remi', '279 Place Charles3, Metz', 'Tarantino.Remi@univ-lorraine.fr', '0297525784');
INSERT INTO "CLIENT" VALUES(3599151610, 6.00, 'Davis', 'Helene', '218 Place jeanne d''arc, Laxou', 'Davis.Helene@univ-lorraine.fr', '0277767115');
INSERT INTO "CLIENT" VALUES(3682546210, 1.00, 'Cobain', 'Marlo', '219 Avenue jeanne d''arc, Metz', 'Cobain.Marlo@univ-lorraine.fr', '0288796428');
INSERT INTO "CLIENT" VALUES(3778298750, 6.00, 'Prodigy', 'Jimmy', '296 Avenue Henri Deglin, Vandoeuvre', 'Prodigy.Jimmy@univ-lorraine.fr', '0275786268');
INSERT INTO "CLIENT" VALUES(4114611710, 4.00, 'Ionesco', 'Marlo', '4 Boulevard des jardiniers, Laxou', 'Ionesco.Marlo@univ-lorraine.fr', '0244847714');
INSERT INTO "CLIENT" VALUES(4218486420, 4.00, 'Stanfield', 'Karadoc', '139 Avenue des jardiniers, Laxou', 'Stanfield.Karadoc@univ-lorraine.fr', '0226753371');
INSERT INTO "CLIENT" VALUES(4367861570, 6.00, 'Davis', 'Omar', '25 Avenue Sellier, Nancy', 'Davis.Omar@univ-lorraine.fr', '0295362868');
INSERT INTO "CLIENT" VALUES(4481244670, 4.00, 'Prodigy', 'Isabelle', '153 Avenue Henri Deglin, Metz', 'Prodigy.Isabelle@univ-lorraine.fr', '0219231853');
INSERT INTO "CLIENT" VALUES(4817135640, 6.00, 'Havoc', 'Omar', '188 Boulevard jeanne d''arc, Laxou', 'Havoc.Omar@univ-lorraine.fr', '0287648224');
INSERT INTO "CLIENT" VALUES(5193115570, 1.00, 'DuLac', 'Avon', '141 Avenue Henri Deglin, Vandoeuvre', 'DuLac.Avon@univ-lorraine.fr', '0287112849');
INSERT INTO "CLIENT" VALUES(5332114160, 3.00, 'Tarantino', 'Remi', '64 Avenue Lobau, Nancy', 'Tarantino.Remi@univ-lorraine.fr', '0242525219');
INSERT INTO "CLIENT" VALUES(5636236850, 10.00, 'Stanfield', 'Yann', '292 Rue Sellier, Metz', 'Stanfield.Yann@univ-lorraine.fr', '0272979196');
INSERT INTO "CLIENT" VALUES(5841723990, 10.00, 'Taha', 'Isabelle', '203 Rue Grande, Vandoeuvre', 'Taha.Isabelle@univ-lorraine.fr', '0257478432');
INSERT INTO "CLIENT" VALUES(5879334710, 5.00, 'Adeba', 'Ali', '224 Place saint-epvre, Laxou', 'Adeba.Ali@univ-lorraine.fr', '0299749735');
INSERT INTO "CLIENT" VALUES(5912642460, 3.00, 'Havoc', 'Ali', '205 Rue Charles3, Nancy', 'Havoc.Ali@univ-lorraine.fr', '0271895759');
INSERT INTO "CLIENT" VALUES(5937158220, 5.00, 'Stanfield', 'Mehdi', '106 Rue Grande, Metz', 'Stanfield.Mehdi@univ-lorraine.fr', '0286619541');
INSERT INTO "CLIENT" VALUES(5942946590, 6.00, 'Tarantino', 'Helene', '264 Boulevard saint-epvre, Metz', 'Tarantino.Helene@univ-lorraine.fr', '0242199235');
INSERT INTO "CLIENT" VALUES(5971779250, 1.00, 'Adeba', 'Adrien', '216 Rue Sellier, Laxou', 'Adeba.Adrien@univ-lorraine.fr', '0292786421');
INSERT INTO "CLIENT" VALUES(5981488590, 3.00, 'Barksdale', 'Helene', '20 Rue Grande, Nancy', 'Barksdale.Helene@univ-lorraine.fr', '0272375436');
INSERT INTO "CLIENT" VALUES(6112742170, 7.00, 'Adeba', 'Mehdi', '79 Place Sellier, Laxou', 'Adeba.Mehdi@univ-lorraine.fr', '0216127359');
INSERT INTO "CLIENT" VALUES(6177491390, 8.00, 'Adeba', 'Jimmy', '100 Boulevard jeanne d''arc, Metz', 'Adeba.Jimmy@univ-lorraine.fr', '0252859677');
INSERT INTO "CLIENT" VALUES(6254695410, 6.00, 'Cobain', 'Adrien', '298 Boulevard des jardiniers, Vandoeuvre', 'Cobain.Adrien@univ-lorraine.fr', '0253814662');
INSERT INTO "CLIENT" VALUES(6275676510, 4.00, 'Stanfield', 'Yann', '32 Place Sellier, Laxou', 'Stanfield.Yann@univ-lorraine.fr', '0294394473');
INSERT INTO "CLIENT" VALUES(6315844110, 2.00, 'Stanfield', 'Perceval', '111 Avenue Grande, Vandoeuvre', 'Stanfield.Perceval@univ-lorraine.fr', '0233174163');
INSERT INTO "CLIENT" VALUES(6364259210, 6.00, 'Ionesco', 'Jimmy', '210 Avenue Sellier, Laxou', 'Ionesco.Jimmy@univ-lorraine.fr', '0296568962');
INSERT INTO "CLIENT" VALUES(6777491680, 5.00, 'Stanfield', 'Helene', '255 Avenue Claudot, Nancy', 'Stanfield.Helene@univ-lorraine.fr', '0275711741');
INSERT INTO "CLIENT" VALUES(7331252860, 8.00, 'Ionesco', 'Mehdi', '232 Boulevard Charles3, Nancy', 'Ionesco.Mehdi@univ-lorraine.fr', '0255669714');
INSERT INTO "CLIENT" VALUES(7432865540, 2.00, 'Havoc', 'Yann', '79 Boulevard jeanne d''arc, Metz', 'Havoc.Yann@univ-lorraine.fr', '0217496191');
INSERT INTO "CLIENT" VALUES(7523691520, 6.00, 'Taha', 'Yann', '126 Rue des jardiniers, Nancy', 'Taha.Yann@univ-lorraine.fr', '0289968727');
INSERT INTO "CLIENT" VALUES(8188114730, 3.00, 'Barksdale', 'Ali', '141 Avenue jeanne d''arc, Vandoeuvre', 'Barksdale.Ali@univ-lorraine.fr', '0239115386');
INSERT INTO "CLIENT" VALUES(8538238810, 2.00, 'Barksdale', 'Remi', '92 Avenue Lobau, Metz', 'Barksdale.Remi@univ-lorraine.fr', '0249798642');
INSERT INTO "CLIENT" VALUES(8588585760, 8.00, 'Ionesco', 'Remi', '145 Boulevard Lobau, Nancy', 'Ionesco.Remi@univ-lorraine.fr', '0239913571');
INSERT INTO "CLIENT" VALUES(8871112790, 7.00, 'DuLac', 'Ali', '112 Boulevard Henri Deglin, Vandoeuvre', 'DuLac.Ali@univ-lorraine.fr', '0291738999');
INSERT INTO "CLIENT" VALUES(9445976950, 9.00, 'Havoc', 'Jimmy', '124 Boulevard Henri Deglin, Nancy', 'Havoc.Jimmy@univ-lorraine.fr', '0225617635');
INSERT INTO "CLIENT" VALUES(9575533350, 8.00, 'Stanfield', 'Perceval', '188 Boulevard Lobau, Laxou', 'Stanfield.Perceval@univ-lorraine.fr', '0229734643');
INSERT INTO "CLIENT" VALUES(9671438920, 8.00, 'Adeba', 'Remi', '272 Boulevard Grande, Nancy', 'Adeba.Remi@univ-lorraine.fr', '0255155737');
INSERT INTO "CLIENT" VALUES(9682778590, 9.00, 'Havoc', 'Mehdi', '86 Rue jeanne d''arc, Laxou', 'Havoc.Mehdi@univ-lorraine.fr', '0265532624');
INSERT INTO "CLIENT" VALUES(9712449720, 1.00, 'Kubrick', 'Ali', '99 Avenue Stanislas, Vandoeuvre', 'Kubrick.Ali@univ-lorraine.fr', '0261966929');
INSERT INTO "CLIENT" VALUES(9794549680, 8.00, 'Davis', 'Adrien', '102 Rue saint-epvre, Nancy', 'Davis.Adrien@univ-lorraine.fr', '0231177714');


--
-- Dumping data for table "PRODUIT"
--

INSERT INTO "PRODUIT" VALUES('12431574596446974350', 'MontLouis', 'MarqueAPasReperer', NULL, 7.00, 'F', 8.00, 115);
INSERT INTO "PRODUIT" VALUES('12595663421373637890', 'Crevettes', 'MarqueAPasReperer', NULL, 6.00, 'F', 6.00, 213);
INSERT INTO "PRODUIT" VALUES('13655334891411833320', 'Truite', 'PastopBudget', NULL, 1.00, 'F', 12.00, 180);
INSERT INTO "PRODUIT" VALUES('13724343589856724190', 'Vouvray', 'MarqueAPasReperer', NULL, 3.00, 'F', 15.00, 176);
INSERT INTO "PRODUIT" VALUES('13871442115845312880', 'Kiwis', 'Pouce', NULL, 13.00, 'F', 14.00, 124);
INSERT INTO "PRODUIT" VALUES('15249766367147185360', 'Perrier', 'MarqueAPasReperer', NULL, 5.00, 'F', 3.00, 235);
INSERT INTO "PRODUIT" VALUES('15617467141432116590', 'Orange', 'MarqueAPasReperer', NULL, 5.00, 'F', 10.00, 131);
INSERT INTO "PRODUIT" VALUES('15748555183839825130', 'Amandes', 'PastopBudget', NULL, 10.00, 'F', 9.00, 150);
INSERT INTO "PRODUIT" VALUES('15981158222851799290', 'Pepsi', 'PastopBudget', NULL, 1.00, 'F', 14.00, 170);
INSERT INTO "PRODUIT" VALUES('16468144999767938740', 'Noisettes', 'Eco-', NULL, 7.00, 'F', 1.00, 277);
INSERT INTO "PRODUIT" VALUES('16656114326835973980', 'Pinot Gris', 'PastopBudget', NULL, 13.00, 'F', 10.00, 246);
INSERT INTO "PRODUIT" VALUES('17237946682357619330', 'Vodka', 'Eco-', NULL, 6.00, 'F', 4.00, 222);
INSERT INTO "PRODUIT" VALUES('17744113973361528860', 'Noisettes', 'PastopBudget', NULL, 13.00, 'F', 7.00, 238);
INSERT INTO "PRODUIT" VALUES('17844294816252217110', 'Dinde', 'Pouce', NULL, 13.00, 'F', 5.00, 228);
INSERT INTO "PRODUIT" VALUES('17955435619151322820', 'Pomme', 'Eco-', NULL, 8.00, 'F', 15.00, 163);
INSERT INTO "PRODUIT" VALUES('18575513674596814690', 'Kiwis', 'MarqueAPasReperer', NULL, 11.00, 'F', 15.00, 265);
INSERT INTO "PRODUIT" VALUES('18712774366744264210', 'Saumon', 'MarqueAPasReperer', NULL, 6.00, 'F', 4.00, 239);
INSERT INTO "PRODUIT" VALUES('18967185498758878940', 'Crevettes', 'Eco-', NULL, 1.00, 'F', 2.00, 168);
INSERT INTO "PRODUIT" VALUES('21754578879935327160', 'Volvic', 'Pouce', NULL, 4.00, 'F', 7.00, 274);
INSERT INTO "PRODUIT" VALUES('22667271672289757640', 'Radis', 'Pouce', NULL, 12.00, 'F', 12.00, 255);
INSERT INTO "PRODUIT" VALUES('22889779227664521840', 'Pommes', 'MarqueAPasReperer', NULL, 5.00, 'F', 9.00, 216);
INSERT INTO "PRODUIT" VALUES('23734476368392437620', 'Costieres de Nimes', 'PastopBudget', NULL, 14.00, 'F', 13.00, 108);
INSERT INTO "PRODUIT" VALUES('24315421697869581340', 'Radis', 'PastopBudget', NULL, 10.00, 'F', 6.00, 275);
INSERT INTO "PRODUIT" VALUES('25448452789519546980', 'Medoc', 'Pouce', NULL, 14.00, 'F', 8.00, 203);
INSERT INTO "PRODUIT" VALUES('25533245649444567280', 'Canard', 'Pouce', NULL, 5.00, 'F', 13.00, 222);
INSERT INTO "PRODUIT" VALUES('25881346415187563440', 'Palourdes', 'MarqueAPasReperer', NULL, 6.00, 'F', 15.00, 198);
INSERT INTO "PRODUIT" VALUES('26123158195648968260', 'Oasis tropical', 'MarqueAPasReperer', NULL, 14.00, 'F', 3.00, 239);
INSERT INTO "PRODUIT" VALUES('26526224997653839790', 'Pomme kiwi', 'PastopBudget', NULL, 3.00, 'F', 5.00, 191);
INSERT INTO "PRODUIT" VALUES('26588416159881774440', 'Bananes', 'MarqueAPasReperer', NULL, 5.00, 'F', 6.00, 190);
INSERT INTO "PRODUIT" VALUES('26634257219355513430', 'Bouillabaisse', 'MarqueAPasReperer', NULL, 15.00, 'F', 1.00, 151);
INSERT INTO "PRODUIT" VALUES('27658557555316214910', 'Reuilly', 'Eco-', NULL, 7.00, 'F', 3.00, 231);
INSERT INTO "PRODUIT" VALUES('27813277788363911140', 'Pessac', 'MarqueAPasReperer', NULL, 9.00, 'F', 15.00, 218);
INSERT INTO "PRODUIT" VALUES('27815138666342679320', 'Vodka', 'MarqueAPasReperer', NULL, 11.00, 'F', 7.00, 123);
INSERT INTO "PRODUIT" VALUES('27958316451723556170', 'Bananes', 'Eco-', NULL, 11.00, 'F', 14.00, 204);
INSERT INTO "PRODUIT" VALUES('28189825466253953510', 'Medoc', 'MarqueAPasReperer', NULL, 1.00, 'F', 13.00, 198);
INSERT INTO "PRODUIT" VALUES('28221571636125289590', 'Poulet', 'Eco-', NULL, 9.00, 'F', 4.00, 261);
INSERT INTO "PRODUIT" VALUES('28262241277148475370', 'Lait de soja', 'MarqueAPasReperer', NULL, 14.00, 'F', 15.00, 206);
INSERT INTO "PRODUIT" VALUES('28546892886951542410', 'Poulet', 'MarqueAPasReperer', NULL, 5.00, 'F', 3.00, 244);
INSERT INTO "PRODUIT" VALUES('28733673225854935130', 'Gin', 'MarqueAPasReperer', NULL, 15.00, 'F', 2.00, 149);
INSERT INTO "PRODUIT" VALUES('28798441957644728230', 'Litchi Orange', 'MarqueAPasReperer', NULL, 11.00, 'F', 7.00, 119);
INSERT INTO "PRODUIT" VALUES('29192215124317212920', 'Oasis Pomme cassis', 'MarqueAPasReperer', NULL, 6.00, 'F', 8.00, 105);
INSERT INTO "PRODUIT" VALUES('29288771468785325720', 'Porc', 'PastopBudget', NULL, 6.00, 'F', 9.00, 166);
INSERT INTO "PRODUIT" VALUES('29414848349615228420', 'Pomme', 'PastopBudget', NULL, 4.00, 'F', 12.00, 150);
INSERT INTO "PRODUIT" VALUES('29799789647654981410', 'Bouillabaisse', 'PastopBudget', NULL, 13.00, 'F', 3.00, 138);
INSERT INTO "PRODUIT" VALUES('31842113177415335650', 'Chou', 'PastopBudget', NULL, 14.00, 'F', 2.00, 167);
INSERT INTO "PRODUIT" VALUES('31884339279891734180', 'Crevettes', 'Pouce', NULL, 1.00, 'F', 11.00, 121);
INSERT INTO "PRODUIT" VALUES('33632869977525442240', 'Chou', 'MarqueAPasReperer', NULL, 6.00, 'F', 10.00, 166);
INSERT INTO "PRODUIT" VALUES('34336628199522941910', 'Moules', 'MarqueAPasReperer', NULL, 1.00, 'F', 11.00, 299);
INSERT INTO "PRODUIT" VALUES('34955558424589742580', 'Bandol', 'MarqueAPasReperer', NULL, 8.00, 'F', 6.00, 223);
INSERT INTO "PRODUIT" VALUES('36524987454344759440', 'Noisettes', 'MarqueAPasReperer', NULL, 8.00, 'F', 11.00, 289);
INSERT INTO "PRODUIT" VALUES('36664882316941662860', 'Pomme', 'MarqueAPasReperer', NULL, 13.00, 'F', 13.00, 199);
INSERT INTO "PRODUIT" VALUES('37494487994761893530', 'Poires', 'Pouce', NULL, 4.00, 'F', 12.00, 260);
INSERT INTO "PRODUIT" VALUES('37885252433986615560', 'Costieres de Nimes', 'Pouce', NULL, 4.00, 'F', 9.00, 274);
INSERT INTO "PRODUIT" VALUES('37979192476283927210', 'Pinot Gris', 'Pouce', NULL, 13.00, 'F', 12.00, 107);
INSERT INTO "PRODUIT" VALUES('37996537434962145790', 'Rozana', 'PastopBudget', NULL, 6.00, 'F', 3.00, 159);
INSERT INTO "PRODUIT" VALUES('38227748662858183660', 'Saumon', 'PastopBudget', NULL, 6.00, 'F', 5.00, 174);
INSERT INTO "PRODUIT" VALUES('39772264698312275360', 'Laitue', 'PastopBudget', NULL, 3.00, 'F', 7.00, 183);
INSERT INTO "PRODUIT" VALUES('39788447553971412890', 'Beaune', 'MarqueAPasReperer', NULL, 1.00, 'F', 15.00, 235);
-- INSERT INTO "PRODUIT" VALUES('41847156274954324350', 'Boeuf', 'MarqueAPasReperer', NULL, 5.00, 'F', 7.00, 281);
INSERT INTO "PRODUIT" VALUES('42849959664246587490', 'Porc', 'MarqueAPasReperer', NULL, 8.00, 'F', 4.00, 198);
INSERT INTO "PRODUIT" VALUES('43358165211665844390', 'Bandol', 'PastopBudget', NULL, 14.00, 'F', 10.00, 224);
INSERT INTO "PRODUIT" VALUES('43482342874668476950', 'Lait de Vache', 'Pouce', NULL, 10.00, 'F', 5.00, 237);
INSERT INTO "PRODUIT" VALUES('43965724653746785480', 'Pomme kiwi', 'Eco-', NULL, 2.00, 'F', 11.00, 126);
INSERT INTO "PRODUIT" VALUES('44965894427331553140', 'Vouvray', 'Pouce', NULL, 7.00, 'F', 5.00, 294);
INSERT INTO "PRODUIT" VALUES('45675166784536541440', 'Canard', 'Eco-', NULL, 14.00, 'F', 7.00, 192);
INSERT INTO "PRODUIT" VALUES('45724816696569733280', 'Hepar', 'PastopBudget', NULL, 6.00, 'F', 6.00, 150);
INSERT INTO "PRODUIT" VALUES('46173535443645898350', 'Bouillabaisse', 'Pouce', NULL, 5.00, 'F', 12.00, 237);
INSERT INTO "PRODUIT" VALUES('46318774679272325370', 'Crevettes', 'PastopBudget', NULL, 4.00, 'F', 5.00, 104);
INSERT INTO "PRODUIT" VALUES('46527362683768873150', 'Gin', 'PastopBudget', NULL, 4.00, 'F', 11.00, 190);
INSERT INTO "PRODUIT" VALUES('47553775341743341970', 'Rozana', 'PastopBudget', NULL, 7.00, 'F', 14.00, 296);
INSERT INTO "PRODUIT" VALUES('47869284118977154770', 'Evian', 'PastopBudget', NULL, 9.00, 'F', 6.00, 190);
INSERT INTO "PRODUIT" VALUES('48311173325853772460', 'Huitres', 'MarqueAPasReperer', NULL, 12.00, 'F', 3.00, 158);
INSERT INTO "PRODUIT" VALUES('48369347475269541640', 'Canard', 'MarqueAPasReperer', NULL, 9.00, 'F', 14.00, 243);
INSERT INTO "PRODUIT" VALUES('51391321241415699710', 'Taureau Rouge', 'Pouce', NULL, 11.00, 'F', 1.00, 287);
INSERT INTO "PRODUIT" VALUES('51759463753578969760', 'Radis', 'MarqueAPasReperer', NULL, 6.00, 'F', 4.00, 142);
INSERT INTO "PRODUIT" VALUES('52658122127276542920', 'Homards', 'MarqueAPasReperer', NULL, 6.00, 'F', 3.00, 111);
INSERT INTO "PRODUIT" VALUES('52943811873541648840', 'Gambas', 'PastopBudget', NULL, 8.00, 'F', 12.00, 231);
INSERT INTO "PRODUIT" VALUES('53541669911558759170', 'Rozana', 'MarqueAPasReperer', NULL, 13.00, 'F', 2.00, 182);
INSERT INTO "PRODUIT" VALUES('53925715834364122370', 'Amandes', 'Eco-', NULL, 8.00, 'F', 10.00, 116);
INSERT INTO "PRODUIT" VALUES('55585375131458471620', 'Hepar', 'MarqueAPasReperer', NULL, 4.00, 'F', 1.00, 155);
INSERT INTO "PRODUIT" VALUES('55944353418824169380', 'Veau', 'PastopBudget', NULL, 2.00, 'F', 10.00, 151);
INSERT INTO "PRODUIT" VALUES('56396571529313176970', 'Huitres', 'Eco-', NULL, 2.00, 'F', 13.00, 196);
INSERT INTO "PRODUIT" VALUES('56772968617993855110', 'Nuggets', 'PastopBudget', NULL, 6.00, 'F', 10.00, 161);
INSERT INTO "PRODUIT" VALUES('56832875623486479260', 'Truite', 'MarqueAPasReperer', NULL, 4.00, 'F', 1.00, 206);
-- INSERT INTO "PRODUIT" VALUES('57111196212246157420', 'Boeuf', 'Pouce', NULL, 8.00, 'F', 15.00, 235);
INSERT INTO "PRODUIT" VALUES('57181266343579497730', 'Lait de Vache', 'PastopBudget', NULL, 12.00, 'F', 5.00, 285);
INSERT INTO "PRODUIT" VALUES('57485384936143157140', 'Palourdes', 'PastopBudget', NULL, 2.00, 'F', 3.00, 117);
INSERT INTO "PRODUIT" VALUES('58752656927199539260', 'Pepsi', 'Pouce', NULL, 5.00, 'F', 15.00, 279);
INSERT INTO "PRODUIT" VALUES('58798729157584594480', 'Pomme', 'Pouce', NULL, 10.00, 'F', 7.00, 283);
INSERT INTO "PRODUIT" VALUES('58923635817423159250', 'Poires', 'MarqueAPasReperer', NULL, 5.00, 'F', 2.00, 123);
INSERT INTO "PRODUIT" VALUES('59639784599515587970', 'Poulet', 'PastopBudget', NULL, 1.00, 'F', 13.00, 191);
INSERT INTO "PRODUIT" VALUES('59997284537649351540', 'Reuilly', 'MarqueAPasReperer', NULL, 11.00, 'F', 13.00, 256);
INSERT INTO "PRODUIT" VALUES('61944265811269923270', 'Gambas', 'MarqueAPasReperer', NULL, 6.00, 'F', 13.00, 114);
INSERT INTO "PRODUIT" VALUES('62497359996972185360', 'Pinot Gris', 'MarqueAPasReperer', NULL, 4.00, 'F', 12.00, 167);
INSERT INTO "PRODUIT" VALUES('62832828147892816340', 'Pomme kiwi', 'MarqueAPasReperer', NULL, 12.00, 'F', 11.00, 100);
INSERT INTO "PRODUIT" VALUES('64748423289518965370', 'Roquette', 'Eco-', NULL, 14.00, 'F', 6.00, 277);
INSERT INTO "PRODUIT" VALUES('66127293465539925570', 'Boeuf', 'PastopBudget', NULL, 12.00, 'F', 6.00, 232);
INSERT INTO "PRODUIT" VALUES('66142265557272782150', 'Whisky', 'PastopBudget', NULL, 11.00, 'F', 1.00, 245);
INSERT INTO "PRODUIT" VALUES('66149793187885294960', 'Evian', 'MarqueAPasReperer', NULL, 12.00, 'F', 7.00, 251);
INSERT INTO "PRODUIT" VALUES('66657731265291943110', 'Noix', 'Pouce', NULL, 11.00, 'F', 7.00, 286);
INSERT INTO "PRODUIT" VALUES('66964126219637877980', 'Truite', 'Eco-', NULL, 11.00, 'F', 9.00, 136);
INSERT INTO "PRODUIT" VALUES('67882499755417783610', 'Perrier', 'PastopBudget', NULL, 7.00, 'F', 4.00, 185);
INSERT INTO "PRODUIT" VALUES('67965874286533171240', 'MontLouis', 'PastopBudget', NULL, 12.00, 'F', 12.00, 265);
-- INSERT INTO "PRODUIT" VALUES('69223714435824526110', 'Boeuf', 'MarqueAPasReperer', NULL, 11.00, 'F', 15.00, 262);
INSERT INTO "PRODUIT" VALUES('69364755368882652210', 'Brocoli', 'MarqueAPasReperer', NULL, 11.00, 'F', 3.00, 186);
INSERT INTO "PRODUIT" VALUES('69746915252799358980', 'Nuggets', 'MarqueAPasReperer', NULL, 2.00, 'F', 11.00, 149);
INSERT INTO "PRODUIT" VALUES('71475773282445228440', 'Chou', 'Pouce', NULL, 5.00, 'F', 15.00, 282);
INSERT INTO "PRODUIT" VALUES('71629911766396578290', 'Chablis', 'MarqueAPasReperer', NULL, 2.00, 'F', 15.00, 221);
INSERT INTO "PRODUIT" VALUES('71796733219182667130', 'Kiwis', 'PastopBudget', NULL, 10.00, 'F', 13.00, 294);
INSERT INTO "PRODUIT" VALUES('72128294939678486770', 'Coka', 'MarqueAPasReperer', NULL, 12.00, 'F', 8.00, 263);
INSERT INTO "PRODUIT" VALUES('72224251213598856110', 'Agneau', 'MarqueAPasReperer', NULL, 15.00, 'F', 2.00, 229);
INSERT INTO "PRODUIT" VALUES('72318899586849687460', 'Roquette', 'MarqueAPasReperer', NULL, 14.00, 'F', 9.00, 116);
INSERT INTO "PRODUIT" VALUES('72613857395882631890', 'Pinot Gris', 'Eco-', NULL, 3.00, 'F', 12.00, 112);
INSERT INTO "PRODUIT" VALUES('72733182754592683270', 'Mache', 'MarqueAPasReperer', NULL, 11.00, 'F', 6.00, 290);
INSERT INTO "PRODUIT" VALUES('73171613255559112170', 'Dinde', 'MarqueAPasReperer', NULL, 10.00, 'F', 12.00, 107);
INSERT INTO "PRODUIT" VALUES('74499792527638585390', 'Orange breeakfast', 'MarqueAPasReperer', NULL, 6.00, 'F', 6.00, 246);
INSERT INTO "PRODUIT" VALUES('74674588277447489130', 'Coka', 'PastopBudget', NULL, 4.00, 'F', 5.00, 267);
INSERT INTO "PRODUIT" VALUES('74762737319816119120', 'Boeuf', 'MarqueAPasReperer', NULL, 13.00, 'F', 4.00, 228);
INSERT INTO "PRODUIT" VALUES('75659345374746874380', 'Sancerre', 'PastopBudget', NULL, 14.00, 'F', 15.00, 205);
INSERT INTO "PRODUIT" VALUES('75825166891212483150', 'Lait d''amande', 'MarqueAPasReperer', NULL, 4.00, 'F', 4.00, 203);
INSERT INTO "PRODUIT" VALUES('76248269842888866810', 'Brocoli', 'Pouce', NULL, 13.00, 'F', 14.00, 116);
INSERT INTO "PRODUIT" VALUES('77662353456562847720', 'Bisque', 'Pouce', NULL, 2.00, 'F', 3.00, 236);
INSERT INTO "PRODUIT" VALUES('78418279338958636830', 'MontLouis', 'Eco-', NULL, 13.00, 'F', 7.00, 295);
INSERT INTO "PRODUIT" VALUES('78699659718318273440', 'Porc', 'Pouce', NULL, 9.00, 'F', 11.00, 252);
INSERT INTO "PRODUIT" VALUES('78924572591589168530', 'Veau', 'MarqueAPasReperer', NULL, 2.00, 'F', 13.00, 186);
INSERT INTO "PRODUIT" VALUES('79391435246114222240', 'Volvic', 'PastopBudget', NULL, 3.00, 'F', 14.00, 257);
INSERT INTO "PRODUIT" VALUES('79991275163873781310', 'Speedup', 'Eco-', NULL, 4.00, 'F', 7.00, 190);
INSERT INTO "PRODUIT" VALUES('81162625379551893160', 'Amandes', 'MarqueAPasReperer', NULL, 7.00, 'F', 11.00, 186);
INSERT INTO "PRODUIT" VALUES('81933741867528218540', 'Rozana', 'MarqueAPasReperer', NULL, 9.00, 'F', 3.00, 247);
INSERT INTO "PRODUIT" VALUES('82186834888916698930', 'Vodka', 'PastopBudget', NULL, 6.00, 'F', 7.00, 160);
INSERT INTO "PRODUIT" VALUES('82421941866725369940', 'Reveil fruite', 'PastopBudget', NULL, 15.00, 'F', 13.00, 179);
INSERT INTO "PRODUIT" VALUES('82712526934259584480', 'Pepsi', 'MarqueAPasReperer', NULL, 7.00, 'F', 11.00, 258);
INSERT INTO "PRODUIT" VALUES('82989169974591697130', 'Speedup', 'Pouce', NULL, 8.00, 'F', 9.00, 121);
INSERT INTO "PRODUIT" VALUES('84312389894717662480', 'Beaune', 'Pouce', NULL, 15.00, 'F', 13.00, 249);
INSERT INTO "PRODUIT" VALUES('84487592431575385570', 'Gin', 'Pouce', NULL, 3.00, 'F', 15.00, 125);
INSERT INTO "PRODUIT" VALUES('84691758143332488140', 'Roquette', 'Pouce', NULL, 14.00, 'F', 6.00, 177);
INSERT INTO "PRODUIT" VALUES('84877749522918668570', 'Pommes', 'Pouce', NULL, 3.00, 'F', 8.00, 245);
INSERT INTO "PRODUIT" VALUES('85447642195769724820', 'Whisky', 'Pouce', NULL, 11.00, 'F', 6.00, 231);
INSERT INTO "PRODUIT" VALUES('85478671544377391330', 'Coca', 'Pouce', NULL, 1.00, 'F', 1.00, 234);
INSERT INTO "PRODUIT" VALUES('85866313863556189410', 'Lait de soja', 'Pouce', NULL, 13.00, 'F', 11.00, 276);
INSERT INTO "PRODUIT" VALUES('86439191429155545460', 'Agneau', 'Pouce', NULL, 1.00, 'F', 9.00, 151);
INSERT INTO "PRODUIT" VALUES('86733946751593613130', 'Noix', 'MarqueAPasReperer', NULL, 4.00, 'F', 10.00, 222);
INSERT INTO "PRODUIT" VALUES('87186693451691521240', 'Reveil fruite', 'MarqueAPasReperer', NULL, 10.00, 'F', 4.00, 236);
INSERT INTO "PRODUIT" VALUES('87373936542751893690', 'Laitue', 'MarqueAPasReperer', NULL, 1.00, 'F', 12.00, 217);
INSERT INTO "PRODUIT" VALUES('87926248535423499180', 'Pinot Blanc', 'MarqueAPasReperer', NULL, 5.00, 'F', 7.00, 299);
INSERT INTO "PRODUIT" VALUES('88146683713992487960', 'Coca', 'MarqueAPasReperer', NULL, 15.00, 'F', 5.00, 193);
INSERT INTO "PRODUIT" VALUES('88155938395572887670', 'Volvic', 'MarqueAPasReperer', NULL, 13.00, 'F', 8.00, 238);
INSERT INTO "PRODUIT" VALUES('89216193855921115620', 'Bouillabaisse', 'Eco-', NULL, 1.00, 'F', 6.00, 159);
INSERT INTO "PRODUIT" VALUES('91336592847298147220', 'Gambas', 'Pouce', NULL, 4.00, 'F', 10.00, 236);
INSERT INTO "PRODUIT" VALUES('91696576668867588130', 'Canard', 'PastopBudget', NULL, 12.00, 'F', 3.00, 137);
INSERT INTO "PRODUIT" VALUES('92366391478579124170', 'Listel', 'MarqueAPasReperer', NULL, 1.00, 'F', 12.00, 217);
INSERT INTO "PRODUIT" VALUES('92769187466395949860', 'Sancerre', 'MarqueAPasReperer', NULL, 14.00, 'F', 11.00, 255);
INSERT INTO "PRODUIT" VALUES('93326698831852797630', 'Rozana', 'Pouce', NULL, 4.00, 'F', 6.00, 278);
INSERT INTO "PRODUIT" VALUES('93845245118826127460', 'Bananes', 'PastopBudget', NULL, 6.00, 'F', 8.00, 211);
INSERT INTO "PRODUIT" VALUES('93869961489848319790', 'Roquette', 'PastopBudget', NULL, 13.00, 'F', 1.00, 141);
INSERT INTO "PRODUIT" VALUES('94197677147836393770', 'Daurade', 'Pouce', NULL, 10.00, 'F', 15.00, 178);
INSERT INTO "PRODUIT" VALUES('94451388697373459760', 'Daurade', 'MarqueAPasReperer', NULL, 10.00, 'F', 13.00, 268);
INSERT INTO "PRODUIT" VALUES('94866522777314237670', 'Lait de Vache', 'MarqueAPasReperer', NULL, 7.00, 'F', 12.00, 281);
INSERT INTO "PRODUIT" VALUES('94952375997495484420', 'Taureau Rouge', 'MarqueAPasReperer', NULL, 8.00, 'F', 8.00, 254);
INSERT INTO "PRODUIT" VALUES('95241889171163596410', 'Perrier', 'Eco-', NULL, 8.00, 'F', 12.00, 242);
INSERT INTO "PRODUIT" VALUES('95886387199146974910', 'Bisque', 'MarqueAPasReperer', NULL, 12.00, 'F', 4.00, 155);
INSERT INTO "PRODUIT" VALUES('96948795811125162970', 'Whisky', 'MarqueAPasReperer', NULL, 10.00, 'F', 5.00, 228);
INSERT INTO "PRODUIT" VALUES('97186918355826742750', 'Truite', 'Pouce', NULL, 10.00, 'F', 9.00, 132);
INSERT INTO "PRODUIT" VALUES('97381324768816222270', 'Gin', 'Eco-', NULL, 3.00, 'F', 12.00, 158);
INSERT INTO "PRODUIT" VALUES('97584933838598412170', 'Pomme kiwi', 'Pouce', NULL, 4.00, 'F', 6.00, 294);
INSERT INTO "PRODUIT" VALUES('97741544254848135210', 'Speedup', 'PastopBudget', NULL, 6.00, 'F', 15.00, 171);
INSERT INTO "PRODUIT" VALUES('97783328974615472580', 'Costieres de Nimes', 'MarqueAPasReperer', NULL, 4.00, 'F', 3.00, 107);
INSERT INTO "PRODUIT" VALUES('98183826576723878460', 'Huitres', 'PastopBudget', NULL, 9.00, 'F', 14.00, 233);
INSERT INTO "PRODUIT" VALUES('98694586189345949940', 'Speedup', 'MarqueAPasReperer', NULL, 5.00, 'F', 13.00, 156);
INSERT INTO "PRODUIT" VALUES('98751936272455835690', 'Evian', 'Pouce', NULL, 1.00, 'F', 14.00, 104);
INSERT INTO "PRODUIT" VALUES('99115193573764198610', 'Reuilly', 'PastopBudget', NULL, 2.00, 'F', 10.00, 122);

--
-- Dumping data for table "PROMOTION"
--

INSERT INTO "PROMOTION" VALUES('1951761830', TO_DATE('2016-04-05', 'yyyy-mm-dd'), TO_DATE('2016-05-03', 'yyyy-mm-dd'), 3);
INSERT INTO "PROMOTION" VALUES('2269319930', TO_DATE('2016-04-27', 'yyyy-mm-dd'), TO_DATE('2016-05-05', 'yyyy-mm-dd'), 2);
INSERT INTO "PROMOTION" VALUES('3377486230', TO_DATE('2016-04-27', 'yyyy-mm-dd'), TO_DATE('2016-05-02', 'yyyy-mm-dd'), 1);
INSERT INTO "PROMOTION" VALUES('3452457180', TO_DATE('2016-04-25', 'yyyy-mm-dd'), TO_DATE('2016-05-27', 'yyyy-mm-dd'), 2);
INSERT INTO "PROMOTION" VALUES('3557414850', TO_DATE('2016-04-22', 'yyyy-mm-dd'), TO_DATE('2016-05-04', 'yyyy-mm-dd'), 3);
INSERT INTO "PROMOTION" VALUES('3779183150', TO_DATE('2016-04-22', 'yyyy-mm-dd'), TO_DATE('2016-05-01', 'yyyy-mm-dd'), 3);
INSERT INTO "PROMOTION" VALUES('4986442180', TO_DATE('2016-04-14', 'yyyy-mm-dd'), TO_DATE('2016-05-09', 'yyyy-mm-dd'), 2);
INSERT INTO "PROMOTION" VALUES('5563155570', TO_DATE('2016-04-14', 'yyyy-mm-dd'), TO_DATE('2016-05-30', 'yyyy-mm-dd'), 2);
INSERT INTO "PROMOTION" VALUES('5782269770', TO_DATE('2016-04-10', 'yyyy-mm-dd'), TO_DATE('2016-05-13', 'yyyy-mm-dd'), 1);
INSERT INTO "PROMOTION" VALUES('7364855640', TO_DATE('2016-04-03', 'yyyy-mm-dd'), TO_DATE('2016-05-13', 'yyyy-mm-dd'), 2);
INSERT INTO "PROMOTION" VALUES('7526618990', TO_DATE('2016-04-18', 'yyyy-mm-dd'), TO_DATE('2016-05-05', 'yyyy-mm-dd'), 2);
INSERT INTO "PROMOTION" VALUES('7988279630', TO_DATE('2016-04-14', 'yyyy-mm-dd'), TO_DATE('2016-05-23', 'yyyy-mm-dd'), 3);
INSERT INTO "PROMOTION" VALUES('8127814190', TO_DATE('2016-04-21', 'yyyy-mm-dd'), TO_DATE('2016-05-10', 'yyyy-mm-dd'), 1);
INSERT INTO "PROMOTION" VALUES('8224833970', TO_DATE('2016-04-22', 'yyyy-mm-dd'), TO_DATE('2016-05-04', 'yyyy-mm-dd'), 3);
INSERT INTO "PROMOTION" VALUES('8548467490', TO_DATE('2016-04-27', 'yyyy-mm-dd'), TO_DATE('2016-05-14', 'yyyy-mm-dd'), 3);
INSERT INTO "PROMOTION" VALUES('8698476130', TO_DATE('2016-04-17', 'yyyy-mm-dd'), TO_DATE('2016-05-26', 'yyyy-mm-dd'), 1);
INSERT INTO "PROMOTION" VALUES('8785476590', TO_DATE('2016-04-22', 'yyyy-mm-dd'), TO_DATE('2016-05-30', 'yyyy-mm-dd'), 3);
INSERT INTO "PROMOTION" VALUES('9396461340', TO_DATE('2016-04-12', 'yyyy-mm-dd'), TO_DATE('2016-05-04', 'yyyy-mm-dd'), 2);
INSERT INTO "PROMOTION" VALUES('9696594640', TO_DATE('2016-04-26', 'yyyy-mm-dd'), TO_DATE('2016-05-17', 'yyyy-mm-dd'), 2);
INSERT INTO "PROMOTION" VALUES('9748734740', TO_DATE('2016-04-01', 'yyyy-mm-dd'), TO_DATE('2016-05-05', 'yyyy-mm-dd'), 3);

--
-- Dumping data for table "P_INDIVIDUELLE"
--

INSERT INTO "P_INDIVIDUELLE" VALUES('3377486230', 20.00, NULL, '1');
INSERT INTO "P_INDIVIDUELLE" VALUES('4986442180', 2.00, NULL, '0');
INSERT INTO "P_INDIVIDUELLE" VALUES('5782269770', 10.00, NULL, '0');
INSERT INTO "P_INDIVIDUELLE" VALUES('7364855640', NULL, 1, '0');
INSERT INTO "P_INDIVIDUELLE" VALUES('7526618990', 1.00, NULL, '1');
INSERT INTO "P_INDIVIDUELLE" VALUES('7988279630', NULL, 1, '0');
INSERT INTO "P_INDIVIDUELLE" VALUES('8548467490', 10.00, NULL, '1');
INSERT INTO "P_INDIVIDUELLE" VALUES('9696594640', 2.00, NULL, '0');
INSERT INTO "P_INDIVIDUELLE" VALUES('9748734740', NULL, 1, '1');

--
-- Dumping data for table "P_LOT"
--

INSERT INTO "P_LOT" VALUES('1951761830', 2, 1);
INSERT INTO "P_LOT" VALUES('2269319930', 3, 1);
INSERT INTO "P_LOT" VALUES('3452457180', 2, 1);
INSERT INTO "P_LOT" VALUES('3557414850', 3, 1);
INSERT INTO "P_LOT" VALUES('3779183150', 3, 1);
INSERT INTO "P_LOT" VALUES('5563155570', 3, 1);
INSERT INTO "P_LOT" VALUES('8127814190', 2, 1);
INSERT INTO "P_LOT" VALUES('8224833970', 2, 1);
INSERT INTO "P_LOT" VALUES('8698476130', 2, 1);
INSERT INTO "P_LOT" VALUES('8785476590', 3, 1);
INSERT INTO "P_LOT" VALUES('9396461340', 2, 1);


--
-- Dumping data for table "OBJET_PROMO"
--

INSERT INTO "OBJET_PROMO" VALUES('1951761830', '13871442115845312880');
INSERT INTO "OBJET_PROMO" VALUES('9748734740', '15981158222851799290');
INSERT INTO "OBJET_PROMO" VALUES('3452457180', '17744113973361528860');
INSERT INTO "OBJET_PROMO" VALUES('9396461340', '17955435619151322820');
INSERT INTO "OBJET_PROMO" VALUES('5563155570', '21754578879935327160');
INSERT INTO "OBJET_PROMO" VALUES('7988279630', '26123158195648968260');
INSERT INTO "OBJET_PROMO" VALUES('8785476590', '26526224997653839790');
INSERT INTO "OBJET_PROMO" VALUES('8698476130', '26634257219355513430');


--
-- Dumping data for table "RAYON"
--

INSERT INTO "RAYON" VALUES('Eaux', 'Boissons');
INSERT INTO "RAYON" VALUES('Lait', 'Boissons');
INSERT INTO "RAYON" VALUES('Sodas', 'Boissons');
INSERT INTO "RAYON" VALUES('Spiritueux', 'Boissons');
INSERT INTO "RAYON" VALUES('Vin', 'Boissons');
INSERT INTO "RAYON" VALUES('Fruits', 'Fruits et Legumes');
INSERT INTO "RAYON" VALUES('Legumes', 'Fruits et Legumes');
INSERT INTO "RAYON" VALUES('Poissonnerie', 'Poissons');
INSERT INTO "RAYON" VALUES('Traiteur', 'Poissons');
INSERT INTO "RAYON" VALUES('Boucherie', 'Viandes');
INSERT INTO "RAYON" VALUES('Volaille', 'Viandes');

--
-- Dumping data for table "SOUS_RAYON"
--

INSERT INTO "SOUS_RAYON" VALUES('Agneau', 'Boucherie');
INSERT INTO "SOUS_RAYON" VALUES('Boeuf', 'Boucherie');
INSERT INTO "SOUS_RAYON" VALUES('Porc', 'Boucherie');
INSERT INTO "SOUS_RAYON" VALUES('Veau', 'Boucherie');
INSERT INTO "SOUS_RAYON" VALUES('De Source', 'Eaux');
INSERT INTO "SOUS_RAYON" VALUES('Magnesienne', 'Eaux');
INSERT INTO "SOUS_RAYON" VALUES('Minerales', 'Eaux');
INSERT INTO "SOUS_RAYON" VALUES('Fruits frais', 'Fruits');
INSERT INTO "SOUS_RAYON" VALUES('Fruits secs', 'Fruits');
INSERT INTO "SOUS_RAYON" VALUES('Jus', 'Fruits');
INSERT INTO "SOUS_RAYON" VALUES('Amande', 'Lait');
INSERT INTO "SOUS_RAYON" VALUES('Soja', 'Lait');
INSERT INTO "SOUS_RAYON" VALUES('Vache', 'Lait');
INSERT INTO "SOUS_RAYON" VALUES('Legumes', 'Legumes');
INSERT INTO "SOUS_RAYON" VALUES('Salades Sachet', 'Legumes');
INSERT INTO "SOUS_RAYON" VALUES('Coquillages', 'Poissonnerie');
INSERT INTO "SOUS_RAYON" VALUES('Crustaces', 'Poissonnerie');
INSERT INTO "SOUS_RAYON" VALUES('Filets', 'Poissonnerie');
INSERT INTO "SOUS_RAYON" VALUES('Aux fruits', 'Sodas');
INSERT INTO "SOUS_RAYON" VALUES('Cola', 'Sodas');
INSERT INTO "SOUS_RAYON" VALUES('Energisant', 'Sodas');
INSERT INTO "SOUS_RAYON" VALUES('Gin', 'Spiritueux');
INSERT INTO "SOUS_RAYON" VALUES('Vodka', 'Spiritueux');
INSERT INTO "SOUS_RAYON" VALUES('Whisky', 'Spiritueux');
INSERT INTO "SOUS_RAYON" VALUES('Marinade', 'Traiteur');
INSERT INTO "SOUS_RAYON" VALUES('Soupes', 'Traiteur');
INSERT INTO "SOUS_RAYON" VALUES('Surimi', 'Traiteur');
INSERT INTO "SOUS_RAYON" VALUES('Blanc', 'Vin');
INSERT INTO "SOUS_RAYON" VALUES('Rose', 'Vin');
INSERT INTO "SOUS_RAYON" VALUES('Rouge', 'Vin');
INSERT INTO "SOUS_RAYON" VALUES('Canard', 'Volaille');
INSERT INTO "SOUS_RAYON" VALUES('Dinde', 'Volaille');
INSERT INTO "SOUS_RAYON" VALUES('Nuggets', 'Volaille');
INSERT INTO "SOUS_RAYON" VALUES('Poulet', 'Volaille');

--
-- Dumping data for table "SOUS_SOUS_RAYON"
--

INSERT INTO "SOUS_SOUS_RAYON" VALUES('Alsace', 'Blanc');
INSERT INTO "SOUS_SOUS_RAYON" VALUES('Berry', 'Blanc');
INSERT INTO "SOUS_SOUS_RAYON" VALUES('Loire', 'Blanc');
INSERT INTO "SOUS_SOUS_RAYON" VALUES('Frais', 'Jus');
INSERT INTO "SOUS_SOUS_RAYON" VALUES('Non frais', 'Jus');
INSERT INTO "SOUS_SOUS_RAYON" VALUES('Smoothies', 'Jus');
INSERT INTO "SOUS_SOUS_RAYON" VALUES('Languedoc', 'Rose');
INSERT INTO "SOUS_SOUS_RAYON" VALUES('Provence', 'Rose');
INSERT INTO "SOUS_SOUS_RAYON" VALUES('Bordelais', 'Rouge');
INSERT INTO "SOUS_SOUS_RAYON" VALUES('Bourgogne', 'Rouge');

--
-- Dumping data for table "SR_P"
--

INSERT INTO "SR_P" VALUES('72224251213598856110', 'Agneau');
INSERT INTO "SR_P" VALUES('86439191429155545460', 'Agneau');
INSERT INTO "SR_P" VALUES('75825166891212483150', 'Amande');
INSERT INTO "SR_P" VALUES('26123158195648968260', 'Aux fruits');
INSERT INTO "SR_P" VALUES('29192215124317212920', 'Aux fruits');
INSERT INTO "SR_P" VALUES('66127293465539925570', 'Boeuf');
INSERT INTO "SR_P" VALUES('74762737319816119120', 'Boeuf');
INSERT INTO "SR_P" VALUES('25533245649444567280', 'Canard');
INSERT INTO "SR_P" VALUES('45675166784536541440', 'Canard');
INSERT INTO "SR_P" VALUES('48369347475269541640', 'Canard');
INSERT INTO "SR_P" VALUES('91696576668867588130', 'Canard');
INSERT INTO "SR_P" VALUES('15981158222851799290', 'Cola');
INSERT INTO "SR_P" VALUES('58752656927199539260', 'Cola');
INSERT INTO "SR_P" VALUES('82712526934259584480', 'Cola');
INSERT INTO "SR_P" VALUES('85478671544377391330', 'Cola');
INSERT INTO "SR_P" VALUES('88146683713992487960', 'Cola');
INSERT INTO "SR_P" VALUES('25881346415187563440', 'Coquillages');
INSERT INTO "SR_P" VALUES('34336628199522941910', 'Coquillages');
INSERT INTO "SR_P" VALUES('48311173325853772460', 'Coquillages');
INSERT INTO "SR_P" VALUES('56396571529313176970', 'Coquillages');
INSERT INTO "SR_P" VALUES('57485384936143157140', 'Coquillages');
INSERT INTO "SR_P" VALUES('98183826576723878460', 'Coquillages');
INSERT INTO "SR_P" VALUES('12595663421373637890', 'Crustaces');
INSERT INTO "SR_P" VALUES('18967185498758878940', 'Crustaces');
INSERT INTO "SR_P" VALUES('31884339279891734180', 'Crustaces');
INSERT INTO "SR_P" VALUES('46318774679272325370', 'Crustaces');
INSERT INTO "SR_P" VALUES('52658122127276542920', 'Crustaces');
INSERT INTO "SR_P" VALUES('52943811873541648840', 'Crustaces');
INSERT INTO "SR_P" VALUES('61944265811269923270', 'Crustaces');
INSERT INTO "SR_P" VALUES('91336592847298147220', 'Crustaces');
INSERT INTO "SR_P" VALUES('15249766367147185360', 'De Source');
INSERT INTO "SR_P" VALUES('37996537434962145790', 'De Source');
INSERT INTO "SR_P" VALUES('53541669911558759170', 'De Source');
INSERT INTO "SR_P" VALUES('67882499755417783610', 'De Source');
INSERT INTO "SR_P" VALUES('95241889171163596410', 'De Source');
INSERT INTO "SR_P" VALUES('17844294816252217110', 'Dinde');
INSERT INTO "SR_P" VALUES('73171613255559112170', 'Dinde');
INSERT INTO "SR_P" VALUES('51391321241415699710', 'Energisant');
INSERT INTO "SR_P" VALUES('72128294939678486770', 'Energisant');
INSERT INTO "SR_P" VALUES('74674588277447489130', 'Energisant');
INSERT INTO "SR_P" VALUES('79991275163873781310', 'Energisant');
INSERT INTO "SR_P" VALUES('82989169974591697130', 'Energisant');
INSERT INTO "SR_P" VALUES('94952375997495484420', 'Energisant');
INSERT INTO "SR_P" VALUES('97741544254848135210', 'Energisant');
INSERT INTO "SR_P" VALUES('98694586189345949940', 'Energisant');
INSERT INTO "SR_P" VALUES('13655334891411833320', 'Filets');
INSERT INTO "SR_P" VALUES('18712774366744264210', 'Filets');
INSERT INTO "SR_P" VALUES('38227748662858183660', 'Filets');
INSERT INTO "SR_P" VALUES('56832875623486479260', 'Filets');
INSERT INTO "SR_P" VALUES('66964126219637877980', 'Filets');
INSERT INTO "SR_P" VALUES('94197677147836393770', 'Filets');
INSERT INTO "SR_P" VALUES('94451388697373459760', 'Filets');
INSERT INTO "SR_P" VALUES('97186918355826742750', 'Filets');
INSERT INTO "SR_P" VALUES('13871442115845312880', 'Fruits frais');
INSERT INTO "SR_P" VALUES('18575513674596814690', 'Fruits frais');
INSERT INTO "SR_P" VALUES('22889779227664521840', 'Fruits frais');
INSERT INTO "SR_P" VALUES('26588416159881774440', 'Fruits frais');
INSERT INTO "SR_P" VALUES('27958316451723556170', 'Fruits frais');
INSERT INTO "SR_P" VALUES('37494487994761893530', 'Fruits frais');
INSERT INTO "SR_P" VALUES('58923635817423159250', 'Fruits frais');
INSERT INTO "SR_P" VALUES('71796733219182667130', 'Fruits frais');
INSERT INTO "SR_P" VALUES('84877749522918668570', 'Fruits frais');
INSERT INTO "SR_P" VALUES('93845245118826127460', 'Fruits frais');
INSERT INTO "SR_P" VALUES('15748555183839825130', 'Fruits secs');
INSERT INTO "SR_P" VALUES('16468144999767938740', 'Fruits secs');
INSERT INTO "SR_P" VALUES('17744113973361528860', 'Fruits secs');
INSERT INTO "SR_P" VALUES('36524987454344759440', 'Fruits secs');
INSERT INTO "SR_P" VALUES('53925715834364122370', 'Fruits secs');
INSERT INTO "SR_P" VALUES('66657731265291943110', 'Fruits secs');
INSERT INTO "SR_P" VALUES('81162625379551893160', 'Fruits secs');
INSERT INTO "SR_P" VALUES('86733946751593613130', 'Fruits secs');
INSERT INTO "SR_P" VALUES('28733673225854935130', 'Gin');
INSERT INTO "SR_P" VALUES('46527362683768873150', 'Gin');
INSERT INTO "SR_P" VALUES('84487592431575385570', 'Gin');
INSERT INTO "SR_P" VALUES('97381324768816222270', 'Gin');
INSERT INTO "SR_P" VALUES('22667271672289757640', 'Legumes');
INSERT INTO "SR_P" VALUES('24315421697869581340', 'Legumes');
INSERT INTO "SR_P" VALUES('31842113177415335650', 'Legumes');
INSERT INTO "SR_P" VALUES('33632869977525442240', 'Legumes');
INSERT INTO "SR_P" VALUES('51759463753578969760', 'Legumes');
INSERT INTO "SR_P" VALUES('69364755368882652210', 'Legumes');
INSERT INTO "SR_P" VALUES('71475773282445228440', 'Legumes');
INSERT INTO "SR_P" VALUES('76248269842888866810', 'Legumes');
INSERT INTO "SR_P" VALUES('45724816696569733280', 'Magnesienne');
INSERT INTO "SR_P" VALUES('47553775341743341970', 'Magnesienne');
INSERT INTO "SR_P" VALUES('55585375131458471620', 'Magnesienne');
INSERT INTO "SR_P" VALUES('81933741867528218540', 'Magnesienne');
INSERT INTO "SR_P" VALUES('93326698831852797630', 'Magnesienne');
INSERT INTO "SR_P" VALUES('21754578879935327160', 'Minerales');
INSERT INTO "SR_P" VALUES('47869284118977154770', 'Minerales');
INSERT INTO "SR_P" VALUES('66149793187885294960', 'Minerales');
INSERT INTO "SR_P" VALUES('79391435246114222240', 'Minerales');
INSERT INTO "SR_P" VALUES('88155938395572887670', 'Minerales');
INSERT INTO "SR_P" VALUES('98751936272455835690', 'Minerales');
INSERT INTO "SR_P" VALUES('56772968617993855110', 'Nuggets');
INSERT INTO "SR_P" VALUES('69746915252799358980', 'Nuggets');
INSERT INTO "SR_P" VALUES('29288771468785325720', 'Porc');
INSERT INTO "SR_P" VALUES('42849959664246587490', 'Porc');
INSERT INTO "SR_P" VALUES('78699659718318273440', 'Porc');
INSERT INTO "SR_P" VALUES('28221571636125289590', 'Poulet');
INSERT INTO "SR_P" VALUES('28546892886951542410', 'Poulet');
INSERT INTO "SR_P" VALUES('59639784599515587970', 'Poulet');
INSERT INTO "SR_P" VALUES('39772264698312275360', 'Salades Sachet');
INSERT INTO "SR_P" VALUES('64748423289518965370', 'Salades Sachet');
INSERT INTO "SR_P" VALUES('72318899586849687460', 'Salades Sachet');
INSERT INTO "SR_P" VALUES('72733182754592683270', 'Salades Sachet');
INSERT INTO "SR_P" VALUES('84691758143332488140', 'Salades Sachet');
INSERT INTO "SR_P" VALUES('87373936542751893690', 'Salades Sachet');
INSERT INTO "SR_P" VALUES('93869961489848319790', 'Salades Sachet');
INSERT INTO "SR_P" VALUES('28262241277148475370', 'Soja');
INSERT INTO "SR_P" VALUES('85866313863556189410', 'Soja');
INSERT INTO "SR_P" VALUES('26634257219355513430', 'Soupes');
INSERT INTO "SR_P" VALUES('29799789647654981410', 'Soupes');
INSERT INTO "SR_P" VALUES('46173535443645898350', 'Soupes');
INSERT INTO "SR_P" VALUES('77662353456562847720', 'Soupes');
INSERT INTO "SR_P" VALUES('89216193855921115620', 'Soupes');
INSERT INTO "SR_P" VALUES('95886387199146974910', 'Soupes');
INSERT INTO "SR_P" VALUES('43482342874668476950', 'Vache');
INSERT INTO "SR_P" VALUES('57181266343579497730', 'Vache');
INSERT INTO "SR_P" VALUES('94866522777314237670', 'Vache');
INSERT INTO "SR_P" VALUES('55944353418824169380', 'Veau');
INSERT INTO "SR_P" VALUES('78924572591589168530', 'Veau');
INSERT INTO "SR_P" VALUES('17237946682357619330', 'Vodka');
INSERT INTO "SR_P" VALUES('27815138666342679320', 'Vodka');
INSERT INTO "SR_P" VALUES('82186834888916698930', 'Vodka');
INSERT INTO "SR_P" VALUES('66142265557272782150', 'Whisky');
INSERT INTO "SR_P" VALUES('85447642195769724820', 'Whisky');
INSERT INTO "SR_P" VALUES('96948795811125162970', 'Whisky');

--
-- Dumping data for table "SSR_P"
--

INSERT INTO "SSR_P" VALUES('16656114326835973980', 'Alsace');
INSERT INTO "SSR_P" VALUES('37979192476283927210', 'Alsace');
INSERT INTO "SSR_P" VALUES('62497359996972185360', 'Alsace');
INSERT INTO "SSR_P" VALUES('72613857395882631890', 'Alsace');
INSERT INTO "SSR_P" VALUES('87926248535423499180', 'Alsace');
INSERT INTO "SSR_P" VALUES('27658557555316214910', 'Berry');
INSERT INTO "SSR_P" VALUES('59997284537649351540', 'Berry');
INSERT INTO "SSR_P" VALUES('75659345374746874380', 'Berry');
INSERT INTO "SSR_P" VALUES('92769187466395949860', 'Berry');
INSERT INTO "SSR_P" VALUES('99115193573764198610', 'Berry');
INSERT INTO "SSR_P" VALUES('25448452789519546980', 'Bordelais');
INSERT INTO "SSR_P" VALUES('27813277788363911140', 'Bordelais');
INSERT INTO "SSR_P" VALUES('28189825466253953510', 'Bordelais');
INSERT INTO "SSR_P" VALUES('39788447553971412890', 'Bourgogne');
INSERT INTO "SSR_P" VALUES('71629911766396578290', 'Bourgogne');
INSERT INTO "SSR_P" VALUES('84312389894717662480', 'Bourgogne');
INSERT INTO "SSR_P" VALUES('74499792527638585390', 'Frais');
INSERT INTO "SSR_P" VALUES('82421941866725369940', 'Frais');
INSERT INTO "SSR_P" VALUES('87186693451691521240', 'Frais');
INSERT INTO "SSR_P" VALUES('23734476368392437620', 'Languedoc');
INSERT INTO "SSR_P" VALUES('37885252433986615560', 'Languedoc');
INSERT INTO "SSR_P" VALUES('97783328974615472580', 'Languedoc');
INSERT INTO "SSR_P" VALUES('12431574596446974350', 'Loire');
INSERT INTO "SSR_P" VALUES('13724343589856724190', 'Loire');
INSERT INTO "SSR_P" VALUES('44965894427331553140', 'Loire');
INSERT INTO "SSR_P" VALUES('67965874286533171240', 'Loire');
INSERT INTO "SSR_P" VALUES('78418279338958636830', 'Loire');
INSERT INTO "SSR_P" VALUES('15617467141432116590', 'Non frais');
INSERT INTO "SSR_P" VALUES('17955435619151322820', 'Non frais');
INSERT INTO "SSR_P" VALUES('29414848349615228420', 'Non frais');
INSERT INTO "SSR_P" VALUES('36664882316941662860', 'Non frais');
INSERT INTO "SSR_P" VALUES('58798729157584594480', 'Non frais');
INSERT INTO "SSR_P" VALUES('34955558424589742580', 'Provence');
INSERT INTO "SSR_P" VALUES('43358165211665844390', 'Provence');
INSERT INTO "SSR_P" VALUES('92366391478579124170', 'Provence');
INSERT INTO "SSR_P" VALUES('26526224997653839790', 'Smoothies');
INSERT INTO "SSR_P" VALUES('28798441957644728230', 'Smoothies');
INSERT INTO "SSR_P" VALUES('43965724653746785480', 'Smoothies');
INSERT INTO "SSR_P" VALUES('62832828147892816340', 'Smoothies');
INSERT INTO "SSR_P" VALUES('97584933838598412170', 'Smoothies');


--
-- Vue V_PRODUIT utile pour avoir la categorie de chaque produit 
-- qu il soit dans un sous-rayon ou un sous-sous-rayon
--

CREATE OR REPLACE VIEW V_PRODUIT (REFERENCE, NOM_CATEGORIE,  NOM_RAYON, NOM_SR )
 AS
(SELECT DISTINCT REFERENCE, NOM_CATEGORIE, NOM_RAYON, NOM_SR 
FROM SR_P JOIN SOUS_RAYON USING (NOM_SR) JOIN RAYON USING(NOM_RAYON))
UNION
(SELECT distinct REFERENCE, NOM_CATEGORIE,  NOM_RAYON, NOM_SR 
 FROM SSR_P JOIN SOUS_SOUS_RAYON USING (NOM_SSR) JOIN SOUS_RAYON USING (NOM_SR) JOIN RAYON USING(NOM_RAYON));




--
-- 4 images pour tous les produits du catalogue	
--

UPDATE PRODUIT P 
SET FICHIER_IMAGE ='IMAGES/BOISSONS.JPG' 
WHERE P.REFERENCE  IN (SELECT REFERENCE FROM V_PRODUIT where nom_categorie='Boissons');


UPDATE PRODUIT P 
SET FICHIER_IMAGE ='IMAGES/POISSONS.JPG' 
WHERE P.REFERENCE  IN (SELECT REFERENCE FROM V_PRODUIT where nom_categorie='Poissons');

UPDATE PRODUIT P 
SET FICHIER_IMAGE ='IMAGES/VIANDES.JPG' 
WHERE P.REFERENCE  IN (SELECT REFERENCE FROM V_PRODUIT where nom_categorie='Viandes');

UPDATE PRODUIT P 
SET FICHIER_IMAGE ='IMAGES/FRUITS_LEGUMES.JPG' 
WHERE P.REFERENCE  IN (SELECT REFERENCE FROM V_PRODUIT where nom_categorie='Fruits et Legumes');

commit;


