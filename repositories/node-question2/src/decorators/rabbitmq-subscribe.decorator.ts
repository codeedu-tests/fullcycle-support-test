import {MethodDecoratorFactory} from '@loopback/metadata';
import {Options} from 'amqplib';

export interface RabbitmqSubscribeMetadata{
  exchange: string;
  routingKey: string | string[];
  queue?: string;
  queueOptions?: Options.AssertQueue;
}

export const RABBITMQ_SUBSCRIBE_DECORATOR = 'rabbitmq-subscribe-metadata'

export function rabbitmqSubscribe(spec: RabbitmqSubscribeMetadata): MethodDecorator{
  return MethodDecoratorFactory.createDecorator<RabbitmqSubscribeMetadata>(
    RABBITMQ_SUBSCRIBE_DECORATOR, spec
  )
}
