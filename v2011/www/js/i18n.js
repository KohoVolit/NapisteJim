/**
* functions for i18n
* thanks, Matthew: http://24ways.org/2007/javascript-internationalisation
*
*/

function _(s) {
  if (typeof(i18n)!='undefined' && i18n[s]) {
    return i18n[s];
  }
  return s;
}

function pretty_num(n) {
  n += '';
  var o = '';
  for (i=n.length; i>3; i-=3) {
    o = i18n.thousands_sep + n.slice(i-3, i) + o;
  }
  o = n.slice(0, i) + o;
  return o;
}

function pluralise(s, p, n) {
  if (n != 1) return _(p);
  return _(s);
}

function sprintf(s) {
  var bits = s.split('%');
  var out = bits[0];
  var re = /^([ds])(.*)$/;
  for (var i=1; i<bits.length; i++) {
    p = re.exec(bits[i]);
    if (!p || arguments[i]==null) continue;
    if (p[1] == 'd') {
     out += parseInt(arguments[i], 10);
    } else if (p[1] == 's') {
      out += arguments[i];
    }
    out += p[2];
  }
  return out;
}
