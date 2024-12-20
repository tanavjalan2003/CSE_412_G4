PGDMP  2    2                |            finalProject    17.0    17.0 $    =           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            >           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            ?           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            @           1262    24581    finalProject    DATABASE     �   CREATE DATABASE "finalProject" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE "finalProject";
                     admin    false                        3079    24615    pgcrypto 	   EXTENSION     <   CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;
    DROP EXTENSION pgcrypto;
                        false            A           0    0    EXTENSION pgcrypto    COMMENT     <   COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';
                             false    2                       1247    32808    task_status    TYPE     Z   CREATE TYPE public.task_status AS ENUM (
    'Pending',
    'Completed',
    'Overdue'
);
    DROP TYPE public.task_status;
       public               phant    false            �            1259    24594    users    TABLE     �   CREATE TABLE public.users (
    "userID" integer NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL
);
    DROP TABLE public.users;
       public         heap r       phant    false            �            1259    24593    Users_UserID_seq    SEQUENCE     �   CREATE SEQUENCE public."Users_UserID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public."Users_UserID_seq";
       public               phant    false    219            B           0    0    Users_UserID_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public."Users_UserID_seq" OWNED BY public.users."userID";
          public               phant    false    218            �            1259    32888 	   analytics    TABLE     �   CREATE TABLE public.analytics (
    userid integer NOT NULL,
    completedtasks integer DEFAULT 0,
    pendingtasks integer DEFAULT 0,
    overduetasks integer DEFAULT 0,
    lastupdated timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.analytics;
       public         heap r       phant    false            �            1259    32797    category    TABLE     �   CREATE TABLE public.category (
    categoryid integer NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    userid integer NOT NULL
);
    DROP TABLE public.category;
       public         heap r       phant    false            �            1259    32796    category_“categoryid”_seq    SEQUENCE     �   CREATE SEQUENCE public."category_“categoryid”_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE public."category_“categoryid”_seq";
       public               phant    false    221            C           0    0    category_“categoryid”_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public."category_“categoryid”_seq" OWNED BY public.category.categoryid;
          public               phant    false    220            �            1259    32851    task    TABLE     "  CREATE TABLE public.task (
    taskid integer NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    duedate date NOT NULL,
    status public.task_status DEFAULT 'Pending'::public.task_status NOT NULL,
    categoryid integer NOT NULL,
    userid integer NOT NULL
);
    DROP TABLE public.task;
       public         heap r       phant    false    895    895            �            1259    32850    task_taskid_seq    SEQUENCE     �   CREATE SEQUENCE public.task_taskid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.task_taskid_seq;
       public               phant    false    223            D           0    0    task_taskid_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.task_taskid_seq OWNED BY public.task.taskid;
          public               phant    false    222            �           2604    32800    category categoryid    DEFAULT     �   ALTER TABLE ONLY public.category ALTER COLUMN categoryid SET DEFAULT nextval('public."category_“categoryid”_seq"'::regclass);
 B   ALTER TABLE public.category ALTER COLUMN categoryid DROP DEFAULT;
       public               phant    false    221    220    221            �           2604    32854    task taskid    DEFAULT     j   ALTER TABLE ONLY public.task ALTER COLUMN taskid SET DEFAULT nextval('public.task_taskid_seq'::regclass);
 :   ALTER TABLE public.task ALTER COLUMN taskid DROP DEFAULT;
       public               phant    false    222    223    223            �           2604    24597    users userID    DEFAULT     p   ALTER TABLE ONLY public.users ALTER COLUMN "userID" SET DEFAULT nextval('public."Users_UserID_seq"'::regclass);
 =   ALTER TABLE public.users ALTER COLUMN "userID" DROP DEFAULT;
       public               phant    false    218    219    219            :          0    32888 	   analytics 
   TABLE DATA                 public               phant    false    224   �'       7          0    32797    category 
   TABLE DATA                 public               phant    false    221   �(       9          0    32851    task 
   TABLE DATA                 public               phant    false    223   h)       5          0    24594    users 
   TABLE DATA                 public               phant    false    219   [*       E           0    0    Users_UserID_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public."Users_UserID_seq"', 20, true);
          public               phant    false    218            F           0    0    category_“categoryid”_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public."category_“categoryid”_seq"', 13, true);
          public               phant    false    220            G           0    0    task_taskid_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.task_taskid_seq', 8, true);
          public               phant    false    222            �           2606    24603    users Users_Email_key 
   CONSTRAINT     S   ALTER TABLE ONLY public.users
    ADD CONSTRAINT "Users_Email_key" UNIQUE (email);
 A   ALTER TABLE ONLY public.users DROP CONSTRAINT "Users_Email_key";
       public                 phant    false    219            �           2606    24601    users Users_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.users
    ADD CONSTRAINT "Users_pkey" PRIMARY KEY ("userID");
 <   ALTER TABLE ONLY public.users DROP CONSTRAINT "Users_pkey";
       public                 phant    false    219            �           2606    32896    analytics analytics_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.analytics
    ADD CONSTRAINT analytics_pkey PRIMARY KEY (userid);
 B   ALTER TABLE ONLY public.analytics DROP CONSTRAINT analytics_pkey;
       public                 phant    false    224            �           2606    32804    category category_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.category
    ADD CONSTRAINT category_pkey PRIMARY KEY (categoryid);
 @   ALTER TABLE ONLY public.category DROP CONSTRAINT category_pkey;
       public                 phant    false    221            �           2606    32859    task task_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.task
    ADD CONSTRAINT task_pkey PRIMARY KEY (taskid);
 8   ALTER TABLE ONLY public.task DROP CONSTRAINT task_pkey;
       public                 phant    false    223            �           2606    32897    analytics analytics_userid_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.analytics
    ADD CONSTRAINT analytics_userid_fkey FOREIGN KEY (userid) REFERENCES public.users("userID") ON DELETE CASCADE;
 I   ALTER TABLE ONLY public.analytics DROP CONSTRAINT analytics_userid_fkey;
       public               phant    false    219    4760    224            �           2606    32906    category category_userid_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.category
    ADD CONSTRAINT category_userid_fkey FOREIGN KEY (userid) REFERENCES public.users("userID") ON DELETE CASCADE;
 G   ALTER TABLE ONLY public.category DROP CONSTRAINT category_userid_fkey;
       public               phant    false    4760    221    219            �           2606    32860    task task_categoryid_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.task
    ADD CONSTRAINT task_categoryid_fkey FOREIGN KEY (categoryid) REFERENCES public.category(categoryid) ON DELETE CASCADE;
 C   ALTER TABLE ONLY public.task DROP CONSTRAINT task_categoryid_fkey;
       public               phant    false    221    223    4762            �           2606    32865    task task_userid_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.task
    ADD CONSTRAINT task_userid_fkey FOREIGN KEY (userid) REFERENCES public.users("userID") ON DELETE CASCADE;
 ?   ALTER TABLE ONLY public.task DROP CONSTRAINT task_userid_fkey;
       public               phant    false    223    4760    219            :   �   x��Թ
�@��>O1]�0w�lV)�D��*DP��(X������ϔU]lUV�F�����t{l�ۥ��j�Z�Z��.�y�r���Ec#;��ƥ�eRNqt��H��<M!�~!��f�9�t�I�^� 
{$챰'�̏���I(�t`�AiO��������������&��iz/      7   �   x���A�0���,���t�� �AZ�m�G7��}���]���������-?��P�/��%�y���|�B�Y0��*L�G1/8T��G	M[��|o�0$�g�Q�?�u��h��D��㿢��3�n=� )�Ba+[N$�k:���%��*/E�>��Ldw��jo<�u��MP9
�#YHoRg�kk�h%]������      9   �   x���K�0���{���&���DA���Y�mMR�o����ޒ���$�-G��Y8�$݊hW�L`ݟ�FK(�
������Xjqt����2�Q��C�2��_%�J���I$��s�/ƾ�Qi�s�Q,(����6���)�#-n�����w���L�����6i���F󮍂�-37A!�|]� ����* l�5c��^f�6����O��� �.��      5   �  x���Y��X���W�PIu'&�L��"����pd<�e��7X�I�r��\�����9k��t�V�n���4D�4���4[2W��_�nZ�Wh@�c*ԉ_v�q��C?-�������Ǿ� �G���U�2{�u��|^��snn��� ;�����ߔ��&�Jʕ	�.�=�I�����.L|ܟ��,���"��������^NJ/��5c'�>nz��n���3�_��L�=�ᘄ&&�%��#Kl�gp����5��T��a	%��h�4�%k6���2�+\]� ��L9�s��J/��7��v��왁/�ɬ�|��Q��>��$Tz��pl����w���p��U��GY|����$��ߘ����=(�'W"��ľ�Q�]�և�y@�2.��L.h��|�-���s�����d8�{3J�� ��@\�7:|�0��[g�֤{=q���g�Ӌ쓁� �"��á�mPx#z3$Ns�J�m:4�:�QQGHs]����#YF�{<�鴂�X�S2��&B�A��2�2]���6yi68W��=�'EV����d�W�j�#mUΞAd�����z<�E-�����b�u��QkIi,6"��ѕ��u��LN&�T+����?�`VohJ����K�	�JV�R��(�����Pd,io�����MEw�sB�7E:�~�Ϯ�B0�7DB,!���}��8	xa��\�����Vu��?�����C����i'��4Z�Iځ�3��0�74dN	�p�ae{�{JM�i)U�HV�Y,��c9^ I����>�E4s�M��5 ��
��x���D��	��ț�+$4돘��rs�e65e��}���&j�ea�l���6~�O�Կ�r�U0�7,�m�i�O�-�Yy�]�A(_/(��q��fD��s��K�E�q�Ɵ��E5̦�Ǘ|��l�fW�)+_]g6��Aۈ��u��f�|�X����
�A����3�e�w��c�I�����W/�g���$��J��#���ܖ�����RtL"9�j�%4Ⱇ�p��2�ρ$V�sE�;��f�+g����4�G�Q7���Y�Q?���Ě��\���r��_����Wʴ��8�vٿ�o^�y�ua���b="<�D��s��,lg;��nَ��}i���۷ \f'�     