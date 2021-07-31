# Cloak+ for UserSpice

This plugin improves the built in cloaking for UserSpice by adding a helper function to cloak with a number of options, and a logout hook to use this as a secondary method of returning to the original user.

## Features

- Callable function for easy cloaking with security checks
- Automatic redirection after cloaking
- Storage and redirection to original destination after cloaking session ended
- Logout button will double as an uncloak button
- Function option overrides including master account check skips, and modifications to the plugins core features

UserSpice can be downloaded from their [website](https://userspice.com/) or on [GitHub](https://github.com/mudmin/UserSpice5).

## Setting Up

### Recommended (via Spice Shaker)

1. Visit Spice Shaker in your Admin Dashboard
2. Search for "IPCheck CloudFlare"
3. Press "Download"
4. Press "Checkout/Install"
5. Enjoy :)

### Manually

1. Download the Release ZIP
2. Upload the Plugin Folder to `usersc/plugins`
3. Visit the Plugin Manager
4. Press "Install Plugin"
5. Enjoy :)

## Example Usage

The `CloakPlus_Cloak` function will return a `state` which can be accessed through the `array`, and in the event the `state` is `false`, it likely will return an `error` as well. If cloaking is successful, the plugin will redirect the user automatically to the homepage. If you disable this, it will return a `state` of `true`. The `state` will always be a `boolean`.

| Behavior                                                                                                                     | Override                     | Error                         |
| ---------------------------------------------------------------------------------------------------------------------------- | ---------------------------- | ----------------------------- |
| Check if there is a user logged in                                                                                           | _None_                       | `not_logged_in`               |
| Check if the provided `cloakTo` variable is an `int` (or can be converted) and is a valid User ID                            | _None_                       | `cloakee_invalid`             |
| Checks if the provided `cloakTo` variable is the same as the cloaker's ID                                                    | _None_                       | `cloakee_is_self`             |
| Check if the cloaker is in the [Master Account Array](https://userspice.com/master-account/)                                 | `skip_master_check`          | `cloaker_not_in_master_array` |
| Check if the cloakee (person being cloaked to) is _not_ in the [Master Account Array](https://userspice.com/master-account/) | `allow_master_cloaking`      | `cloakee_in_master_array`     |
| Store URI that the user cloaked from, to redirect them back to after                                                         | `do_not_store_original_dest` | _None_                        |
| Logging out triggers uncloaking                                                                                              | `disable_logout_uncloak`     | _None_                        |
| Auto redirect on cloaking                                                                                                    | `no_redirect_on_success`     | _None_                        |

### Basic Usage

```php
# Placeholder Variables
$userId = 100;
$errors = [];

$cloak = CloakPlus_Cloak($userId);
if (!$cloak['state']) {
    $errors[] = $cloak['error'] ?? 'There was an error processing your request';
}
```

### Advanced Usage

#### Disable Logout Uncloak Feature

```php
# Placeholder Variables
$userId = 100;
$errors = [];

$cloak = CloakPlus_Cloak($userId, ['disable_logout_uncloak']);
if (!$cloak['state']) {
    $errors[] = $cloak['error'] ?? 'There was an error processing your request';
}
```

#### Skip Master Check (Allows Other Users)

```php
# Placeholder Variables
$userId = 100;
$errors = [];

$cloak = CloakPlus_Cloak($userId, ['skip_master_check']);
if (!$cloak['state']) {
    $errors[] = $cloak['error'] ?? 'There was an error processing your request';
}
```

## Questions or Issues

If you have any issues please open an issue here on GitHub. This includes feature requests. If you wish to resolve an issue, you may complete a pull request. Please do not make a pull request for features without opening an issue first.

Pull Requests are expected to be validated with PHP CS Fixer using the following standards. A config file for this is included in the repo.

```
@PSR2, @Symfony, -phpdoc_annotation_without_dot, -phpdoc_no_alias_tag, -phpdoc_separation, -yoda_style
```

Any help with UserSpice can be asked in their [Discord](https://discord.gg/j25FeHu).
