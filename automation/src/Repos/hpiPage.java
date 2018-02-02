package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class hpiPage {
	
	
	
	public static WebElement HPIComment(WebDriver driver) {
		return driver.findElement(By.id("HPI"));
	}
	
	public static WebElement HPISaveButton(WebDriver driver) {
		return driver.findElement(By.id("save_button"));
	}
	
	//confirm exists
	public static WebElement HPIResetButton(WebDriver driver) {
		return driver.findElement(By.id("btn_clear_HPI_comment"));
	}
	

}
