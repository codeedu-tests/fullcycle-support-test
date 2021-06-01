import IRegisterUserDTO from "../dtos/IRegisterUserDTO";
import User from "../infra/typeorm/entities/User";

export default interface IUsersRepository {
    create(data: IRegisterUserDTO): Promise<User>
    findByEmail(email: string): Promise<User | undefined>
    findById(id: string): Promise<User | undefined>
}