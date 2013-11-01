INSERT INTO #__categories (parent_id, extension, title, alias, path, published, level, access, created_time, language)        
SELECT * FROM (SELECT 1 as parent_id, 'com_content', 'Twitter' as t, 'twitter' as a, 'twitter' as p, 1 as published, 1 as level, 1 as access, NOW(), '*') AS tmp
WHERE NOT EXISTS(     
    SELECT id   
    FROM #__categories 
    WHERE alias = "twitter"
);   


INSERT INTO #__categories (parent_id, extension, title, alias, path, published, level, access, created_time, language)        
SELECT * FROM (SELECT 1 as parent_id, 'com_content', 'Instagram' as t, 'instagram' as a, 'instagram' as p, 1 as published, 1 as level, 1 as access, NOW(), '*') AS tmp
WHERE NOT EXISTS(     
    SELECT id   
    FROM #__categories 
    WHERE alias = "instagram"
);   


INSERT INTO #__categories (parent_id, extension, title, alias, path, published, level, access, created_time, language)        
SELECT * FROM (SELECT 1 as parent_id, 'com_content', 'Facebook' as t, 'facebook' as a, 'facebook' as p, 1 as published, 1 as level, 1 as access, NOW(), '*') AS tmp
WHERE NOT EXISTS(     
    SELECT id   
    FROM #__categories 
    WHERE alias = "facebook"
);

DROP TABLE IF EXISTS #__activategrid;
CREATE TABLE #__activategrid (
    id int(11) primary key auto_increment,
    context varchar(25),
    name varchar(25),
    value varchar(255)
);