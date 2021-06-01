import {Client} from 'es7'
import {default as chalk} from 'chalk'
import {MicroCatalogApplication} from '../application'
import {config} from '../config'
import {Esv7DataSource} from '../datasources'
import fixtures from '../fixtures'
import {DefaultCrudRepository} from '@loopback/repository'
import {ValidatorsComponent} from '../components'
import {ValidatorService} from '../services/validator.service'

export class FixturesCommand {
  static command = 'fixtures'
  static description = "Fixtures data in ElasticSearch"

  app: MicroCatalogApplication

  async run(){
    console.log(chalk.green('Fixture data'))
    await this.bootApp()
    console.log(chalk.green('Delete all documents'));
    await this.deleteAllDocuments()

    const validator = this.app.getSync<ValidatorService>('services.ValidatorService')

    for(const fixture of fixtures){
      const repository = this.getRepository<DefaultCrudRepository<any, any>>(fixture.model)
      await validator.validate({
        data: fixture.fields,
        entityClass: repository.entityClass
      })
      await repository.create(fixture.fields)
    }
    console.log(chalk.green('Documents generated!'));
  }

  private async bootApp(){
    this.app = new MicroCatalogApplication(config)
    await this.app.boot()
  }

  private async deleteAllDocuments(){
    const datasource: Esv7DataSource = this.app.getSync<Esv7DataSource>('datasources.esv7')
    // @ts-ignore
    const index = datasource.adapter.settings.index
    // @ts-ignore
    const client: Client = datasource.adapter.db
    await client.deleteByQuery({
      index,
      body: {
        query: {match_all: {}}
      }
    })
  }

  private getRepository<T>(modelName: string): T{
    return this.app.getSync(`repositories.${modelName}Repository`)
  }

}
