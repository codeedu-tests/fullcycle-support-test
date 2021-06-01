import { Response, Request } from "express";
import { container } from "tsyringe";
import IRegisterUserDTO from "../../dtos/IRegisterUserDTO";
import CreateUserService from "../../services/createUser/CreateUserService";

export default class CreateUserController {

    async handle(req: Request, res: Response): Promise<Response> {
        const data: IRegisterUserDTO = req.body
        const createUserService = container.resolve(CreateUserService)

        const user = await createUserService.execute(data)

        return res.status(201).json(user)
    }

}