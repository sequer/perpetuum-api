### Validation
- add nice messages to validators (e.g. email on account), as they are shown directly on forms
- in development mode, a listener should be added that modifies email input to affix the SparkPost sink domain (e.g. `.sink.sparkpostmail.com`, see https://www.sparkpost.com/docs/faq/using-sink-server).
