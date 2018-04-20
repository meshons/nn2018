#pragma once
#include <fstream>
#include <string>

struct config {
	std::string ip, user, pass, db, table, rtable, file;
	unsigned char type, cycle;
	bool load(const char * nev) {
		std::ifstream conf(nev);
		for (;;) {
			if (conf.eof() || conf.bad() || conf.peek() == EOF)
				break;
			std::string name, data;
			getline(conf, name, '=');
			getline(conf, data);
			if (name == "ip")ip = data;
			else if (name == "user")user = data;
			else if (name == "pass")pass = data;
			else if (name == "db")db = data;
			else if (name == "table")table = data;
			else if (name == "rtable")rtable = data;
			else if (name == "file")file = data;
			else if (name == "versioncycle")cycle = std::stoi(data);
			else if (name == "type") {
				if (data == "result")type = 1;
				else if (data == "start")type = 2;
			}
		}
		conf.close();
		return true;
	}
};