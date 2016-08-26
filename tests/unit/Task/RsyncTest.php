<?php

use AspectMock\Test as test;
use Robo\Robo;

class RsyncTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $guy;

    // tests
    public function testRsync()
    {
        verify(
            (new \Robo\Task\Remote\Rsync())
                ->fromPath('src/')
                ->toHost('localhost')
                ->toUser('dev')
                ->toPath('/var/www/html/app/')
                ->recursive()
                ->excludeVcs()
                ->checksum()
                ->wholeFile()
                ->verbose()
                ->progress()
                ->humanReadable()
                ->stats()
                ->getCommand()
        )->equals(
            sprintf(
                'rsync --recursive --exclude %s --exclude %s --exclude %s --checksum --whole-file --verbose --progress --human-readable --stats %s %s',
                escapeshellarg('.git'),
                escapeshellarg('.svn'),
                escapeshellarg('.hg'),
                escapeshellarg('src/'),
                escapeshellarg('dev@localhost:/var/www/html/app/')
            )
        );

        verify(
            (new \Robo\Task\Remote\Rsync())
                ->fromPath('src/foo bar/baz')
                ->toHost('localhost')
                ->toUser('dev')
                ->toPath('/var/path/with/a space')
                ->getCommand()
        )->equals(
            sprintf(
                'rsync %s %s',
                escapeshellarg('src/foo bar/baz'),
                escapeshellarg('dev@localhost:/var/path/with/a space')
            )
        );
    }
}