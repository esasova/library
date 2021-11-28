export default function ({ $auth, redirect }) {
    const user = $auth.user
    if (!user) {
      $auth.logout()
      redirect('/login')
    }
  }
