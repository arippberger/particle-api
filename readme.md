=== Particle API ===
Contributors: arippberger
Donate link: http://alecrippberger.com/
Tags: internet of things
Requires at least: 4.4
Tested up to: 4.5
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is an example plugin to demonstrate how to integrate a Particle Photon/Electron/Core with the WordPress API.

== Description ==

The "Internet of Things" (IoT) is the emergence of a number of devices that provide utility to the physical world via
the web (or vice versa - providing utility to the web through physical devices).

Particle (formerly Spark) provides several devices that aimed at "Makers" that facilitate the creation of new IoT devices.
The Particle device (Photon, Electron, or Core) is an internet-enabled micro-controller. It combines digital and analog
electrical inputs/outputs with WiFi and multiprocessing chips. With the right know-how, a Particle device could allow you
to start preheating your oven from your phone; it could allow you to keep track of the water content of your garden soil
from a website; it could allow you to build a toy to play with your cat from the web.

== What You'll Want for this Demo ==

In order to fully take advantage of this demo you'll want the following things:

*   A Particle device
*   Some dev & electronics chops
*   A WordPress website running 4.4 or higher (with several plugins installed -- including this one)
*   Access to the Internet

== Setup ==

Here is a list of steps you should take to get the demo set up.

1. Assuming you have a Particle device - register it. Once registered and on a WiFi network,
flash it with the code located in the particle-files folder
1. You'll want to set up your Particle device as according to the code flashed (see schematic @todo - add schematic)
1. Setup your WP site: requires 4.4 or higher. Install these plugins: 'Application Passwords', 'WP REST API',
and this ('Particle API')
1. Assign an application password to a user (Dashboard -> Users -> Edit) and copy it
1. Base64 encode the user's username and password like this 'username:password'. You can do this in Terminal (bash)
using this command: echo -n "USERNAME:PASSWORD" | base64
1. Add this info to the proper project files - you can search 'Authorization'

== Frequently Asked Questions ==

= Gee, I have a question =

Yes! You with your hand up!

== Screenshots ==

Someday.

== Changelog ==

= 1.0 =

