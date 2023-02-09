#!/bin/bash
# Check DDEV version
CURRENT_DIR=$(dirname "$0");
source "${CURRENT_DIR}/bash/helpers/colors.sh";


function show_banner() {
    echo -e "${bldblu}=========================================================="
    echo -e "> Magento 2 DDEV environment started successfully. "
    echo -e "==========================================================${txtrst}"
}
show_banner
cd ~
CURRENT=$(printenv | grep -E "^DDEV_VERSION=v(.*)$" | sed 's/DDEV_VERSION=v//g')
EXPECTED=$(cat DDEV_EXPECTED_VERSION.txt)

if [[ $CURRENT == $EXPECTED ]]
then
  echo -en "${txtgrn}${check_mark} DDEV version is as expected: $CURRENT ${txtrst} \n"
else
  echo -e "${bldylw}=========================="
  echo -e "> WARNING!!!"
  echo -e "==========================${txtrst}"
  echo -en "${bldylw}${cross_mark} DDEV version ($CURRENT) is not the expected one: $EXPECTED ${txtrst} \n"
fi
