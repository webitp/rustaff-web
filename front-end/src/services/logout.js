import Cookies from 'js-cookie'

export default function () {
  Cookies.remove('token');
  location.reload();
}