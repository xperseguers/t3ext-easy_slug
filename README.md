# Easy Slug

This mini-extension has been inspired by "slug_autoupdate", namely that it
automatically updates  the slug field for pages, after editing the title or
moving the page.

It is targeting TYPO3 v10 (and not v9) because v10 has added support for doing
that for the editor but, for some reason, the developers who implemented this
long-awaited feature did not want to go "that far" and the redirect business
logic ensuring that the old slug will redirect to the new one is triggered only
when the editor is manually editing the slug field.

This is something that is really strange as one would expect everything to
happen when a page title is edited from within the page tree, and when a page is
moved around.

In addition, I would logically expect the alternative navigation title to be
used instead of the title if it is defined, but this does not happen natively.
So this extension will use that field to generate the slug in place of the
title, if present.


## Installation

At the moment the extension is not available off the TYPO3 Extension Repository
(TER). As such you are encouraged to install it via composer:

```
composer req causal/easy_slug:dev-master
```

And then? Well... just forget about it! It is meant to make working with slug
finally easy and so it does.

Do not hesitate to open a ticket if this is not the case.


## Known Limitations

In TYPO3 v10, when you edit a page and manually change the slug and then save,
you get a notification with quick actions to revert the changes and/or the
automatic creation of redirects from the old slug to the new one.

When you change the page title (or navigation title) from within the page tree,
the renaming action happens outside the regular editing workflow (AJAX call),
and the Core notification is not available. This means that the notification
prompt does not pop up. The same lack of confirmation notification can be
triggered when you move a page or a group of pages.

It is worth mentioning however that this is actually a limitation of TYPO3 v10
as you can reproduce this UX inconsistency by editing a page, changing the slug,
closing and when asked whether you want to save change, click the "save and
close" button. In that context, the notification does not pop up either.
