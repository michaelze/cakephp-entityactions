Vagrant.configure("2") do |config|

    config.vm.box = "generic/ubuntu1804"

    config.vm.synced_folder ".", "/vagrant"


    config.vm.provision "shell" do |s|
        s.inline = "DEBIAN_FRONTEND=noninteractive apt-get update"
        s.inline = "DEBIAN_FRONTEND=noninteractive apt-get install -y php php-intl php-mbstring php-dom composer"
    end

end