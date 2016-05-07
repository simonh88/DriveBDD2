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
    REDUCTION_ABSOLUE NUMBER(13,2)  NULL,
    REDUCTION_RELATIVE NUMBER(1)  NULL,
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


-- -----------------------------------------------------------------------------
--                FIN DE GENERATION
-- -----------------------------------------------------------------------------