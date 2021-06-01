import { Router } from 'express'

import accountsRoutes from './accounts.routes'
import authenticateRoutes from './authenticate.routes'

const routes = Router()

routes.use('/users', accountsRoutes)
routes.use('/sessions', authenticateRoutes)

export default routes
