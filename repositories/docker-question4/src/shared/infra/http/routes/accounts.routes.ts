import CreateUserController from '@modules/users/infra/controllers/CreateUserController'
import UpdateUserAvatarController from '@modules/users/infra/controllers/UpdateUserAvatarController'
import Router from 'express'

import multer from 'multer'
import uploadConfig from '../../../../config/upload'
import ensureAuthenticated from '../middlewares/ensureAuthenticated'

const accountsRoutes = Router()

const uploadAvatar = multer(uploadConfig.upload('./tmp/avatar'))

const createUserController = new CreateUserController()
const updateUserAvatarController = new UpdateUserAvatarController()

accountsRoutes.post('/', createUserController.handle)

accountsRoutes.patch('/avatar', ensureAuthenticated, uploadAvatar.single("avatar"), updateUserAvatarController.handle)

export default accountsRoutes