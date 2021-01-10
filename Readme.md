## Running Server

```bash
sudo docker run --name=badger --privileged --env SECRET_KEY=yousaf -d --restart=unless-stopped -p 5005:5005 crowphp/badger-server
``