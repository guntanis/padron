# Ejemplo de API para Consulta de Padrón Electoral

 > Código no esta abstracto, ni OO, por la poca complejidad del proyecto. Pero es fácilmente abstraible e implementable en un método con cambios mínimos.

## Requerimientos:
  - Webserver. (Apache (Sirve con cualquiera, pero hay que jugarsela con el
    .htacces/rewrite rule))
  - API:
    + PHP 5.5+
    + MongoDB PECL Module.
  - Base de Datos:
    + MongoDB 

## Base de Datos
El export de la base de datos en mongo (BSON) se encuenta en el directorio data. Como 1GB más o menos.

Descomprimir los datos:
```
tar zxvf padron.json.tgz
```

Para importar estos datos:
```
mongoimport --db padron --collection padron --file padron.json
```

Crear el índice usando el Mongo CLI
```
    use padron;
    db.padron.ensureIndex({"CEDULA" : 1});
```
## Software
  Poner el index.php y el .htacces en un directorio accesible por HTTP.



  
