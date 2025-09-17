# Xupport GF Assistenza

Plugin custom per modulistica di assistenza (Gravity Forms) con integrazione API Xupport:

- Wizard: prima accensione / intervento tecnico
- Province/Comuni da API
- Modelli/Compatibilità errori da API
- Upload file -> API (uuid)
- Invio finale -> API POST

## Configurazione

Impostare in `wp-config.php` (o come variabili d'ambiente):

```php
putenv('XUPPORT_API_BASE=https://testapi.xupport.it:443');
putenv('XUPPORT_API_AUTH=...chiave...');
putenv('XUPPORT_API_USER=integrazione_sito');
putenv('XUPPORT_API_PASS=********');
```
