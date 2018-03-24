### Register

`POST /onboarding/register`

Request body (`Content-Type: application/json`)
```
{
  "email": "mail@example.com",
  "password": "foobar"
}
```
`204` response on succesful account creation (account is available immediately). `422` response (`Content-Type: application/problem+json`) on validation issues.

### Verify

`POST /onboarding/verify/:token`

`token` was sent using the transactional mail. `204` response on succesful account verification. `404` response on any failure.
