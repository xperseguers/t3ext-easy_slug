# Easy Slug

This mini-extension has been inspired by "slug_autoupdate", namely that it automatically updates
the slug field for pages, after editing the title or moving the page.

It is targeting TYPO3 v10 (and not v9) because v10 has added support for doing that for the editor
but for some reasons, the developers who implemented this long-awaited feature did not want to go
"that far" and the redirect business logic ensuring that the old slug will redirect to the new one
is triggered only when the editor is manually editing the slug field.

This is something that is really strange as one would expect everything to happen when a page title
is edited from within the page tree, and when a page is moved around.

In addition, I would logically expect the alternative navigation title to be used instead of the
title if it is defined, but this does not happen natively. So this extension will use that field
to generate the slug in place of the title, if present.

## Installation

```
composer req causal/easy_slug:dev-master
```