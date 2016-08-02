/*!
 * Toot Pay (https://github.com/klarizonemar/tootpay)
 * Author: Klarizon Emar Motol
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});