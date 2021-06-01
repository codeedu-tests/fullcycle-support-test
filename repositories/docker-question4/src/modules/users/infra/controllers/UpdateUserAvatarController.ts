import { Request, Response } from "express";
import { container } from "tsyringe";
import UpdateUserAvatarService from "../../services/updateUserAvatar/UpdateUserAvatarService";

export default class UpdateUserAvatarController {

    async handle(req: Request, res: Response): Promise<Response> {
        const user_id = req.user_id

        const avatar_file = req.file.filename

        const updateUserAvatarUserCase = container.resolve(UpdateUserAvatarService)
        await updateUserAvatarUserCase.execute({ user_id, avatar_file })

        return res.status(204).json()
    }

}