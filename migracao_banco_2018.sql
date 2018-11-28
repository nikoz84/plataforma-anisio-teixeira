-- EXTENSÃO SEM ACENTOS
CREATE EXTENSION IF NOT EXISTS unaccent;
-- DESHABILITA TRIGGERS
ALTER TABLE conteudodigital DISABLE TRIGGER ALL;

--- LIMPA EMAILS REPETIDOS

with emails as (
select email,
       count(*)
from usuario
group by email
having count(*) > 1
) select u.idusuario, u.username, u.nomeusuario, u.email from usuario as u 
  join emails as e on e.email = u.email

--
update usuario set email = (concat('deletar_',email)) where idusuario = 115;
update usuario set email = (concat('deletar_',email)) where idusuario = 65;
update usuario set email = (concat('deletar_',email)) where idusuario = 1237;
update usuario set email = (concat('deletar_',email)) where idusuario = 200;
update usuario set email = (concat('deletar_1_',email)) where idusuario = 47;
update usuario set email = (concat('deletar_2_',email)) where idusuario = 198;
update usuario set email = (concat('deletar',email)) where idusuario = 708;
update usuario set email = (concat('deletar_1_',email)) where idusuario = 707;
update usuario set email = (concat('deletar_2_',email)) where idusuario = 706;
update usuario set email = (concat('deletar',email)) where idusuario = 435;
update usuario set email = (concat('deletar_1',email)) where idusuario = 434;
update usuario set email = (concat('deletar',email)) where idusuario = 1546;
update usuario set email = (concat('deletar',email)) where idusuario = 225;
update usuario set email = (concat('deletar_1_',email)) where idusuario = 223;
update usuario set email = (concat('deletar_2_',email)) where idusuario = 222;
update usuario set email = (concat('deletar_3_',email)) where idusuario = 221;
update usuario set email = (concat('deletar',email)) where idusuario = 94;
update usuario set email = (concat('deletar',email)) where idusuario = 712;
update usuario set email = (concat('deletar',email)) where idusuario = 527;
update usuario set email = (concat('deletar',email)) where idusuario = 1692;

-- LIMPA TAGS

select * from tag

with tags as (
select nometag,
       count(*)
from tag
group by nometag
having count(*) > 1
) select t.idtag, t.nometag from tag as t join tags as tgs on tgs.nometag = t.nometag

--
update tag set nometag = (concat('deletar_',nometag)) where idtag = 3438;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 7045;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 3804;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 2285;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 7746;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 7527;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 4699;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 1843;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 13360;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 4200;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 13491;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 13737;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 1312;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 3618;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 7135;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 2790;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 11482;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 4720;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 8346;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 2888;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 3369;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 8846;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 13746;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 11481;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 8716;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 7220;
update tag set nometag = (concat('deletar_',nometag)) where idtag = 7520;

-- EXPORTAR USUARIOS
COPY (
    select u.idusuario as id, 
	    u.nomeusuario as name,
	    u.email as email,	
	    case when u.senha is null then md5('teste') else u.senha end as password,
            jsonb_build_object('role', (select ut.nomeusuariotipo from usuariotipo as ut where ut.idusuariotipo = u.idusuariotipo),
		'is_active', u.flativo,
		'sexo', u.sexo,
		'birthday', u.datanascimento,
		'telefone', telefone,
		'neighborhood', bairro	
            ) as options,
            null as remember_token,
            u.datacriacao as created_at,
            u.dataatualizacao as updated_at	
    from usuario as u  
) TO '/home/niko/Documentos/db/MIGRA/final/1.users' WITH (FORMAT text, DELIMITER '*')

-- EXPORTAR CANAIS
copy (
  select idcanal as id,
        nomecanal as name,
	descricaocanal as description,
	nomemodulocanal as slug,
	flativo as is_active,
	case when idcanal = 8 then tokencanal else null end AS token,
	jsonb_build_object('url', case when idcanal = 7 then urlcanal when idcanal =8 then urlcanal else null end,
		'has_about', flpossuisobre,
		'tipo_conteudo', conteudotipocanal,
		'color', corcanal,
		'title', titulomenucanal,
		'quick_access', flacessorapido,
		'has_categories', flcategoria,
		'complement_description', jsonb_build_object('que',descricaooquecanal,'porque',descricaoporquecanal,'como',descricaocomocanal)	
	) AS options,
	now()::timestamp as created_at,
	null as updated_at,
	null as deletet_at
  from canal			
) to '/home/niko/Documentos/db/MIGRA/final/2.canais' WITH ( FORMAT TEXT, DELIMITER '*' );

-- EXPORTAR TAGS
copy(
SELECT idtag as id,
       nometag as name,
       busca as searched,
       (select now()::timestamp) as created_at,
       dataatualizacao as updated_at
FROM tag
) to '/home/niko/Documentos/db/MIGRA/final/3.tags' WITH ( FORMAT TEXT, DELIMITER '*' );

select * from ambientedeapoio
-- EXPORTAR APLICATIVOS
COPY(
SELECT aa.idambientedeapoio as id,
		aa.idusuariopublicador as user_id,
		aa.idambientedeapoiocategoria as category_id,
		9 as canal_id,
		aa.titulo as name, 
		aa.descricao as description,
		aa.url AS url,
		fldestaque AS is_featured, 
		jsonb_build_object(
			'category', jsonb_build_object('name', aac.nomeambientedeapoiocategoria, 'slug', regexp_replace(lower(unaccent(concat(aac.nomeambientedeapoiocategoria))),'[^a-zA-Z0-9]+', '-','g')),
			'qt_access', aa.acessos,
			'tags', (SELECT jsonb_agg(jsonb_build_object('id',tag.idtag, 'name', tag.nometag)) FROM ambientedeapoiotag INNER JOIN tag ON tag.idtag = ambientedeapoiotag.idtag WHERE ambientedeapoiotag.idambientedeapoio = aa.idambientedeapoio)
		) as options, 		
		now()::timestamp as created_at,
		null as updated_at
	FROM ambientedeapoio aa
	INNER JOIN ambientedeapoiocategoria aac 
	ON aa.idambientedeapoiocategoria = aac.idambientedeapoiocategoria
) to '/home/niko/Documentos/db/MIGRA/final/4.aplicativos' WITH ( FORMAT TEXT, DELIMITER '*' );


-- EXPORTAR APLICATIVO_TAG
COPY(
select idambientedeapoio as aplicativo_id, idtag as tag_id from ambientedeapoiotag
) to '/home/niko/Documentos/db/MIGRA/final/5.aplicativo_tag' WITH ( FORMAT TEXT, DELIMITER '*' );
-- EXPORTAR AMBIENTE DE APOIO CATEGORIA
COPY (
select  idambientedeapoiocategoria as id,
       nomeambientedeapoiocategoria as name
from ambientedeapoiocategoria
) to '/home/niko/Documentos/db/MIGRA/final/6.aplicativo_categories' WITH (FORMAT TEXT, DELIMITER '*')
-- EXPORTAR TIPOS

select f.*, ct.* from formato as f
join conteudotipo as ct on ct.idconteudotipo = f.idconteudotipo

-- EXPORTAR CONTEUDOS
copy (
with conteudos as (
SELECT 	 cd.idconteudodigital as id,
	 cd.idcanal as canal_id,
	 cd.idusuariopublicador as user_id,
	 cd.idusuariopublicador as approving_user_id,
	 cd.idlicencaconteudo as license_id,
	 cd.idconteudodigitalcategoria as category_id,
	 cd.titulo as title,
	 cd.descricao as description,
	 cd.autores as authors,
	 cd.fonte as source,
	 cd.datapublicacao as created_at,
	 null as updated_at,
	 null as deleted_at,
	 cd.flaprovado as is_approved,
	 cd.flsitetematico as is_site,
	 cd.fldestaque as is_featured,
	 (case when cd.qtddownloads is null then 0 else cd.qtddownloads end) as qt_downloads,	
	 (case when cd.acessos is null then 0 else cd.acessos end) as qt_access,
	 cd.site
	 ,(SELECT jsonb_build_object('id', ct.idconteudotipo, 'name',ct.nomeconteudotipo) FROM conteudotipo AS ct JOIN formato AS f ON f.idformato = cd.idformato AND ct.idconteudotipo = f.idconteudotipo) as tipo
	 ,(SELECT jsonb_agg(jsonb_build_object('id',tag.idtag, 'name', tag.nometag)) FROM conteudodigitaltag INNER JOIN tag ON tag.idtag = conteudodigitaltag.idtag WHERE conteudodigitaltag.idconteudodigital = cd.idconteudodigital) as tags
	 ,(SELECT jsonb_agg(jsonb_build_object('id',cc.idcomponentecurricular, 'name', cc.nomecomponentecurricular)) FROM conteudodigitalcomponente as cdc INNER JOIN componentecurricular as cc on cc.idcomponentecurricular = cdc.idcomponentecurricular WHERE cdc.idconteudodigital = cd.idconteudodigital) as componentes	
	,(SELECT case when fv.nomeformato = 'link' then cd.site when fv.nomeformato is not null then concat(cd.idconteudodigital,'.',fv.nomeformato) else '' end from formato as fv where fv.idformato = cd.idformato) AS visualizacao
	,(SELECT case when fd.nomeformato = 'link' then cd.site when fd.nomeformato is not null then concat(cd.idconteudodigital,'.',fd.nomeformato) else '' end from formato as fd where fd.idformato = cd.idformatodownload) AS download
	,(SELECT case when fg.nomeformato is not null then concat(cd.idconteudodigital,'.',fg.nomeformato) else '' end from formato as fg where fg.idformato = cd.idformatoguiapedagogico) AS guia_pedagogica
	,setweight( to_tsvector( 'simple', (SELECT string_agg(lower(COALESCE(unaccent(t.nometag),'')), ' ' ) FROM conteudodigitaltag AS ct INNER JOIN tag t ON t.idtag = ct.idtag WHERE ct.idconteudodigital = cd.idconteudodigital)), 'A') ||
	 setweight( to_tsvector( 'simple', lower( COALESCE( unaccent(cd.titulo), '') ) ), 'B' ) ||
	 setweight( to_tsvector( 'portuguese', unaccent( lower( COALESCE( cd.fonte, '') ) ) ), 'C' ) ||
	 setweight( to_tsvector( 'portuguese', unaccent( lower( COALESCE( cd.autores, '') ) ) ), 'C' ) ||
	 setweight( to_tsvector( 'portuguese', unaccent(lower(
			regexp_replace(
			regexp_replace(
			regexp_replace( cd.descricao 
			, E'<.*?>', '', 'g')
			, E'&nbsp;', ' ', 'g')
			, E'[\\n\\r]+', ' ', 'g')
		))),'D') AS ts_documento
FROM conteudodigital cd
INNER JOIN usuario ON usuario.idusuario = cd.idusuariopublicador
) select id, canal_id, user_id, approving_user_id, license_id, category_id, title, 
        description, authors, source, is_approved, is_featured, is_site,
        qt_downloads, qt_access,
        jsonb_build_object('tipo',tipo,
                        'tags',tags,
                        'componentes',componentes, 
                        'site', site,
                        'download', download,
                        'visualizacao', visualizacao,
                        'guia', guia_pedagogica
                        ) as options,
        created_at, updated_at, deleted_at                
        , ts_documento
from conteudos ) to '/home/niko/Documentos/db/MIGRA/final/6.conteudos' WITH ( FORMAT TEXT, DELIMITER '*' )
  

-- EXPORTAR CONTEUDO_TAG
COPY(
select idconteudodigital as conteudo_id, idtag as tag_id from conteudodigitaltag
) to '/home/niko/Documentos/db/MIGRA/final/7.conteudo_tag' WITH ( FORMAT TEXT, DELIMITER '*' );

-- EXPORTAR LICENSES 
COPY(
select idconteudolicenca as id,idconteudolicencapai as parent_id, nomeconteudolicenca as name, descricaoconteudolicenca as description, siteconteudolicenca as site 
from conteudolicenca	
) to '/home/niko/Documentos/db/MIGRA/final/8.licenses' WITH ( FORMAT TEXT, DELIMITER '*' );

-- EXPORTAR CATEGORIAS
COPY(
select sc.idconteudodigitalcategoria AS id,
      sc.idconteudodigitalcategoriapai as parent_id,
      sc.idcanal as canal_id,	
      sc.nomeconteudodigitalcategoria AS name,
      jsonb_build_object(
	'is_active', flativo,
	'is_featured', fldestaque,
	'description', sc.descricaoconteudodigitalcategoria
      ) as options,
      sc.datacriacao as created_at,
      null as updated_at
from conteudodigitalcategoria AS sc
) to '/home/niko/Documentos/db/MIGRA/final/9.categories' WITH ( FORMAT TEXT, DELIMITER '*' );






