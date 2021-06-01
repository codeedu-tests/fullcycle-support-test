import AuthenticateUserController from '@modules/users/infra/controllers/AuthenticateUserController'
import Router from 'express'

const authenticateRoutes = Router()

const authenticateUserController = new AuthenticateUserController()

authenticateRoutes.post('/', authenticateUserController.handle)

export default authenticateRoutes