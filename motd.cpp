#include <iostream>
#include <fstream>
#include <cstdlib>
#include <string>
#include <vector>
#include <ctime>

std::vector<std::string> readFile(std::string fileName){
	std::vector<std::string> data;
	std::string line;

	std::ifstream file(fileName.c_str());
	if(file.is_open()){
		while(getline(file, line)){
			data.push_back(line);
		}
	}
	else{
		std::cout << "ERROR: cannot read file" << std::endl;
		exit(0);
	}
	return data;
}

void setMotd(std::string quote){
	std::vector<std::string> writeData = readFile("server.properties");
	std::string line;

	std::ofstream file("server.properties");
	if(file.is_open()){
		for(unsigned i = 0; i < writeData.size(); i++){
			line = writeData[i];
			if(line.find("motd") == std::string::npos){
				file << line << "\n";
			}
			else{
				file << "motd=" << quote << "\n";
			}
		}
		file.close();
	}
	else{
		std::cout << "ERROR: cannot write to server.properties" << std::endl;
	}

}

int main(int argc, char const *argv[]){
	std::vector<std::string> data = readFile("quotes.txt");

	std::srand(std::time(NULL));
	int idx = std::rand() % data.size();

	std::cout << "motd: " << data[idx] << std::endl;

	setMotd(data[idx]);

	return 0;
}