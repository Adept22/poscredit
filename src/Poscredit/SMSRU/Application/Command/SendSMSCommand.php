<?php

namespace App\Poscredit\SMSRU\Application\Command;

use App\Poscredit\SMSRU\Application\Service\SendSMSService;
use App\Poscredit\SMSRU\Application\Model\SendSMSModel;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\HandleTrait;

#[AsCommand(
    name: 'app:sms:send',
    description: 'Send a new sms.',
    aliases: [],
    hidden: false
)]
final class SendSMSCommand extends Command
{
    use HandleTrait;
    
    private SendSMSService $sendSMSService;

    public function __construct(SendSMSService $sendSMSService)
    {
        $this->sendSMSService = $sendSMSService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to send a sms...')
                ->addArgument('to', InputArgument::REQUIRED, 'SMS receivers (format "<NUMBER>,<NUMBER>,...")')
                ->addArgument('message', InputArgument::REQUIRED, 'SMS text')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'SMS Sender (sms.ru)',
            '============',
            '',
        ]);

        $output->writeln('You are about to send sms');
        
        $sendSMSModel = new SendSMSModel(
            explode(",", $input->getArgument('to'), 21), // Костыль из-за макс. длины строки в БД из 255 символов (21 * 11 + 20 = 251)
            $input->getArgument('message')
        );

        $result = $this->handle($sendSMSModel);

        $output->writeln([
            'SMS Sended : ',
            '',
        ]);

        $output->write($result);

        return Command::SUCCESS;
    }
}