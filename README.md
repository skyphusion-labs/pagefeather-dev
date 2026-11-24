# pagefeather.dev

Marketing theme and page fixtures for [www.pagefeather.dev](https://www.pagefeather.dev/).

This repository holds the site theme. Deploy tooling lives in [skyphusion-labs/pagefeather](https://github.com/skyphusion-labs/pagefeather).

## Layout

```
assets/logo.svg
wp-content/themes/pagefeather-site/
content/*.json
```

`assets/logo.svg` is the product mark. The theme also ships the same artwork at `wp-content/themes/pagefeather-site/assets/img/mark.svg`.

`content/*.json` holds optional page fixtures. These files have no credentials.

## Deploy

Run deploy from a checkout of the engine repository. Point `IMPORT_CONTENT` at this repository.

Worker name is `pagefeather`. Variant is `b-dosql`. Do not route a new zone without a CR issue.

```sh
MARKETING=/path/to/pagefeather-dev

IMPORT_CONTENT="$MARKETING/wp-content" IMPORT_THEMES=pagefeather-site REPLACE_INPUTS=1 \
  VARIANT=b-dosql LOCATION=enam MEDIA=1 WOO_ACTIVE=0 BENCH=0 \
  OPCACHE_REMOTE=1 SITE_REMOTE=1 \
  CUSTOM_DOMAIN=www.pagefeather.dev \
  NAME=pagefeather ./deploy/deploy.sh
```

Then activate `pagefeather-site` in Appearance > Themes.

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).

Fonts are SIL OFL 1.1 (DM Sans, Instrument Serif, JetBrains Mono). They are self-hosted under the theme `assets/fonts/` tree.
