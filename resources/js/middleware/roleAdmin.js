// export default function roleAdmin({ store, next }) {
//   if (
//     !store.getters['auth/authenticated'] ||
//     (!store.state.auth.roles.superAdmin && !store.state.auth.roles.admin)
//   ) {
//     return next({
//       name: 'NotFound',
//     });
//   }
//   return next();
// }

import axios from 'axios';

export default async function roleAdmin({ store, next, to }) {
  const isAuthenticated = store.getters['auth/authenticated'];
  const isAdmin = store.state.auth.roles.admin;
  const isSuperAdmin = store.state.auth.roles.superAdmin;

  if (!isAuthenticated || (!isSuperAdmin && !isAdmin)) {
    return next({
      name: 'NotFound',
    });
  }

  try {
    const response = await axios.get('/api/get/permissions');
    const permissions = response.data;
    console.log('permissions', permissions);
    const route = to.name;
    const requiredPermission = permissions.find(
      (permission) => permission.slug === route,
    );
    console.log('requiredPermission', requiredPermission);
    if (!requiredPermission) {
      return next({
        name: 'NotFound',
      });
    }

    //
    // const hasPermission = store.getters['auth/hasPermission'](
    //   requiredPermission ? requiredPermission.slug : null,
    // );
    //
    // console.log('hasPermission', hasPermission);
    //
    // if (!hasPermission) {
    //   return next({
    //     name: 'NotFound',
    //   });
    // }

    return next();
  } catch (error) {
    console.log('error', error);
  }
}
