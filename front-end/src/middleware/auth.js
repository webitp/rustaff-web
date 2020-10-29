import store from '@/store';

export default async function ({ next }) {
  if (!store.state.user) return next({ name: 'Home' });
  return next();
}