import auth from '@/services/auth';
import store from '@/store';

export default async function () {
  const data = (await auth.post()).data;
  if (data.auth)
    store.state.user = data.content;
  else
    store.state.loginUrl = data.content;
}