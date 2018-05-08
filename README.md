# Spark Shower GIF Booth
Three cameras, an angle grinder, and you.

![Sample GIF](https://github.com/jasoneppink/spark-shower-GIF-booth/blob/master/sparkshowergifbooth.gif)

## Hardware Requirements
* 3 cameras and lenses of similar quality supported by [gphoto2 image capture](http://gphoto.org/proj/libgphoto2/support.php). My setup included a Canon 7D, Canon 5D Mark II, and Canon 5D Mark III. (Any number of cameras can theoretically work as long as you have enough USB ports.)
* 3 tripods
* 3 [USB A to Mini-B cables](https://www.amazon.com/C2G-Cables-27005-Toshiba-Panasonic/dp/B000067RVL/)
* 1 [USB hub](https://www.amazon.com/Sabrent-4-Port-Individual-Switches-HB-UM43/dp/B00JX1ZS5O/)
* 3 [remote shutter release cables](https://www.amazon.com/gp/product/B002KDS2BY/) wired in parallel. (Drawing coming soon...)
* plexiglass shield
* Mac or Linux computer. (Installation instructions assume a Mac.)
* external monitor w/ keyboard and mouse (for viewing/emailing station)

## Theory of Operation
Three cameras are triggered simultaneously by remote shutter release cables wired in parallel. Three simultaneous gphoto2 terminal commands listen on three USB ports for new photos. When photos are detected, they are downloaded to ~/Sites/raw. When filewatch.sh, running in the background, detects new files in this directory, it runs sparkbooth.sh to convert the JPEGs to still GIFs and assemble them into an animated GIF. The final GIF is saved to ~/Sites/gifs and the JPEGs are moved to ~/Sites/old and a timestampe is appended to their filenames.

## Installation
1. Install Homebrew (if you don't already have it).
  ```
   /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
  ```
2. Install necessary libraries.
  ```
  brew install imagemagick gifsicle gphoto2 imagemagick mail
  ```
3. Set up mail/postfix to enable emailing. ([Differs by operating system.](https://bl.ocks.org/larrybotha/6009971))

5. Fire up your local webserver. ([Differs by operating system.](https://discussions.apple.com/docs/DOC-3083))

6. Place filewatch.sh, index.php, and sparkbooth.sh in ~/Sites/. Create directories named "gifs", "old", and "raw" in ~/Sites/.

7. Set up cameras with same shutter speed, aperture, and ISO. Align cameras so the subject is in the same location in all three frames. (This will take some experimentation once the rest of the booth is setup.) Place plexiglass shield in front of cameras.

8. With all three cameras connected by USB and turned on, find their port numbers:
  ```
  gphoto2 —-list-ports
  ```
9. Open up three windows in Terminal and run one of these commands for each of the USB ports. (The filename assignments may need to be adjusted later based on camera placement: camera2 needs to be the middle camera.)
  ```
  gphoto2 --capture-tethered --port usb:###,### --filename ~/Sites/raw/camera1.jpg --force-overwrite
  gphoto2 --capture-tethered --port usb:###,### --filename ~/Sites/raw/camera2.jpg --force-overwrite
  gphoto2 --capture-tethered --port usb:###,### --filename ~/Sites/raw/camera3.jpg --force-overwrite
  ```
10. In another Terminal window, run:
  ```
  bash filewatch.sh
  ```
12. In a browser, navigate to localhost/~YOURUSERNAME and place on the external monitor. This is where participants browse and email to themselves. It will have to be manually refreshed to update with new GIFs.

13. Fire away! Leave at least five seconds between each camera trigger. (If you don't, photos capturing slightly earlier or later moments may intermingle. This may be a desired effect.)
