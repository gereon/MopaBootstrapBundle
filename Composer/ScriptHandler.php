<?php
/**
 * Script for composer, to symlink bootstrap lib into Bundle + Font-Awesome (only for less)
 *
 * Maybe nice to convert this to a command and then reuse command in here.
 */
namespace Mopa\Bundle\BootstrapBundle\Composer;

use Composer\Script\Event;
use Mopa\Bridge\Composer\Util\ComposerPathFinder;
use Mopa\Bundle\BootstrapBundle\Command\BootstrapSymlinkLessCommand;
use Mopa\Bundle\BootstrapBundle\Command\BootstrapSymlinkSassCommand;

class ScriptHandler
{

    public static function postInstallSymlinkTwitterBootstrap(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $cmanager = new ComposerPathFinder($composer);
        $options = array(
            'targetSuffix' => DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "bootstrap",
            'sourcePrefix' => '..' . DIRECTORY_SEPARATOR
        );
        list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(
            BootstrapSymlinkLessCommand::$mopaBootstrapBundleName,
            BootstrapSymlinkLessCommand::$twitterBootstrapName,
            $options
        );

        $optionsFontAwesome = array(
                'targetSuffix' => DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "Font-Awesome",
                'sourcePrefix' => '..' . DIRECTORY_SEPARATOR
            );
        list($symlinkTargetFontAwesome, $symlinkNameFontAwesome) = $cmanager->getSymlinkFromComposer(
            BootstrapSymlinkLessCommand::$mopaBootstrapBundleName,
            BootstrapSymlinkLessCommand::$fontAwesomeName,
            $optionsFontAwesome
        );

        $IO->write("Checking Symlink Bootstrap. ", FALSE);
        if (false === BootstrapSymlinkLessCommand::checkSymlink($symlinkTarget, $symlinkName, true)) {
            $IO->write("Creating Symlink Bootstrap: " . $symlinkName, FALSE);
            BootstrapSymlinkLessCommand::createSymlink($symlinkTarget, $symlinkName);
        }
        $IO->write(" ... <info>OK</info>");

        $IO->write("Checking Symlink FontAwesome. ", FALSE);
        if (false === BootstrapSymlinkLessCommand::checkSymlink($symlinkTargetFontAwesome, $symlinkNameFontAwesome, true)) {
            $IO->write("Creating Symlink FontAwesome: " . $symlinkNameFontAwesome, FALSE);
            BootstrapSymlinkLessCommand::createSymlink($symlinkTargetFontAwesome, $symlinkNameFontAwesome);
        }

        $IO->write(" ... <info>OK</info>");
    }

    public static function postInstallSymlinkTwitterBootstrapSass(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $cmanager = new ComposerPathFinder($composer);
        $options = array(
            'targetSuffix' => DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "bootstrap-sass",
            'sourcePrefix' => '..' . DIRECTORY_SEPARATOR
        );
        list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(
            BootstrapSymlinkSassCommand::$mopaBootstrapBundleName,
            BootstrapSymlinkSassCommand::$twitterBootstrapName,
            $options
        );

        $IO->write("Checking Symlink", FALSE);
        if (false === BootstrapSymlinkSassCommand::checkSymlink($symlinkTarget, $symlinkName, true)) {
            $IO->write(" ... Creating Symlink: " . $symlinkName, FALSE);
            BootstrapSymlinkSassCommand::createSymlink($symlinkTarget, $symlinkName);
        }
        $IO->write(" ... <info>OK</info>");
    }
}