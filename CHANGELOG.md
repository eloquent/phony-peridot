# Phony for Peridot changelog

## 3.0.0 (2020-01-06)

This release uses *Phony* `4.x`. There no BC breaking API changes aside from
stricter type declarations.

- **[BC BREAK]** PHP 7.1 is no longer supported.

## 2.0.0 (2017-09-29)

This release uses *Phony* `2.x` under the hood. Check out the
[migration guide][migration-2] for *Phony* `2.x`, which also applies to this
release.

- **[BC BREAK]** PHP 5 is no longer supported ([#216]).
- **[BC BREAK]** HHVM is no longer supported ([#216], [#219]).
- **[IMPROVED]** Support for PHP 7.2 features, including the `object` typehint
  ([#224]).
- **[IMPROVED]** Support for the PHP 7.1 `iterable` typehint in automatically
  injected suites and tests.

[migration-2]: https://github.com/eloquent/phony/blob/2.0.0/MIGRATING.md#migrating-from-1x-to-2x
[#216]: https://github.com/eloquent/phony/issues/216
[#219]: https://github.com/eloquent/phony/issues/219
[#224]: https://github.com/eloquent/phony/issues/224

## 1.0.0 (2017-04-24)

- **[IMPROVED]** Updated to use the new Phony `1.0.0` release.

## 0.2.0 (2017-04-24)

- **[BC BREAK]** Renamed from `peridot-phony` to `phony-peridot`, to match new
  integration repository conventions.

## 0.1.0 (2016-08-05)

- **[NEW]** Initial release.
